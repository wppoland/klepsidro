<?php
/**
 * PRO upgrade promotion for the Ticker settings screen.
 *
 * @package Ticker\Admin
 */

declare(strict_types=1);

namespace Ticker\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * PRO upgrade promotion, shown ONLY on the Ticker settings screen: a dismissible
 * top banner, a sidebar promo panel, and a "what PRO adds" locked-card list.
 *
 * It is pure advertising: no disabled form fields, nothing blocks a free
 * workflow, it is scoped to this one screen and the banner is dismissible per
 * user. That keeps it inside the WordPress.org guidelines (no admin hijacking,
 * no trialware). Content comes from config/pro-upsell.php, generated from the
 * plogins.com registry, so the feature copy always matches the real PRO edition.
 *
 * @package Ticker\Admin
 */
final class ProUpsell {

	private const META   = 'ticker_pro_banner_dismissed';
	private const ACTION = 'ticker_dismiss_pro';

	/**
	 * Lazily-loaded upsell content from config/pro-upsell.php.
	 *
	 * @var array<string, mixed>|null
	 */
	private ?array $data = null;

	/**
	 * Register the admin-post handler for the dismiss link.
	 */
	public function registerHooks(): void {
		add_action( 'admin_post_' . self::ACTION, array( $this, 'handleDismiss' ) );
	}

	/**
	 * Load and cache the generated upsell content.
	 *
	 * @return array<string, mixed>
	 */
	private function data(): array {
		if ( null === $this->data ) {
			$file       = \Ticker\PLUGIN_DIR . '/config/pro-upsell.php';
			$this->data = is_readable( $file ) ? (array) require $file : array();
		}

		return $this->data;
	}

	/**
	 * Whether to render the promo at all (filterable for white-label builds).
	 *
	 * @return bool
	 */
	public function enabled(): bool {
		/**
		 * Filters whether the Ticker PRO promo is shown on the settings screen.
		 *
		 * @param bool $show Default true.
		 */
		return (bool) apply_filters( 'ticker/show_pro_cta', true ) && array() !== $this->features();
	}

	/**
	 * The URL the "Upgrade to PRO" buttons point at.
	 *
	 * @return string
	 */
	private function url(): string {
		$default = (string) ( $this->data()['url'] ?? 'https://plogins.com/plogins-ticker-pro/pricing/' );

		/**
		 * Filters the URL the "Upgrade to PRO" buttons point at.
		 *
		 * @param string $url Default the Ticker PRO pricing page.
		 */
		return (string) apply_filters( 'ticker/pro_url', $default );
	}

	/**
	 * Whether the current site locale is Polish.
	 *
	 * @return bool
	 */
	private function isPolish(): bool {
		return str_starts_with( (string) get_locale(), 'pl' );
	}

	/**
	 * Human-readable "from X/yr" price label in the current locale.
	 *
	 * @return string
	 */
	private function priceLabel(): string {
		$d = $this->data();
		if ( $this->isPolish() && ! empty( $d['price_pln'] ) ) {
			/* translators: %d: yearly price in PLN. */
			return sprintf( __( 'od %d zł/rok', 'plogins-ticker' ), (int) $d['price_pln'] );
		}
		if ( ! empty( $d['price_from'] ) ) {
			$cur = 'EUR' === ( $d['currency'] ?? 'EUR' ) ? '€' : (string) $d['currency'] . ' ';
			/* translators: 1: currency symbol, 2: yearly price. */
			return sprintf( __( 'from %1$s%2$d/yr', 'plogins-ticker' ), $cur, (int) $d['price_from'] );
		}

		return '';
	}

	/**
	 * The curated feature list resolved to the current locale.
	 *
	 * @return array<int, array{title: string, desc: string}>
	 */
	private function features(): array {
		$lang = $this->isPolish() ? 'pl' : 'en';
		$out  = array();
		foreach ( (array) ( $this->data()['features'] ?? array() ) as $f ) {
			$x = is_array( $f ) ? ( $f[ $lang ] ?? $f['en'] ?? null ) : null;
			if ( is_array( $x ) && ! empty( $x['title'] ) ) {
				$out[] = array(
					'title' => (string) $x['title'],
					'desc'  => (string) ( $x['desc'] ?? '' ),
				);
			}
		}

		return $out;
	}

	/**
	 * Whether the current user has dismissed the banner.
	 *
	 * @return bool
	 */
	public function bannerDismissed(): bool {
		return (bool) get_user_meta( get_current_user_id(), self::META, true );
	}

	/**
	 * Nonce-protected admin-post URL that dismisses the banner.
	 *
	 * @return string
	 */
	private function dismissUrl(): string {
		return wp_nonce_url( admin_url( 'admin-post.php?action=' . self::ACTION ), self::ACTION );
	}

	/**
	 * Handle the dismiss link: record the per-user preference and redirect back.
	 */
	public function handleDismiss(): void {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'plogins-ticker' ) );
		}
		check_admin_referer( self::ACTION );
		update_user_meta( get_current_user_id(), self::META, 1 );
		wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url( 'admin.php?page=ticker-settings' ) );
		exit;
	}

	// Render pieces.

	/**
	 * Render the dismissible strip at the top of the settings screen.
	 */
	public function banner(): void {
		if ( ! $this->enabled() || $this->bannerDismissed() ) {
			return;
		}
		$name     = (string) ( $this->data()['name'] ?? 'Ticker Pro' );
		$price    = $this->priceLabel();
		$subtitle = implode(
			', ',
			array_slice(
				array_map(
					static fn ( array $f ): string => $f['title'],
					$this->features(),
				),
				0,
				3,
			),
		);
		?>
		<div class="ticker-pro-banner" role="note">
			<span class="ticker-pro-banner__tag">PRO</span>
			<p class="ticker-pro-banner__text">
				<strong>
				<?php
				/* translators: %s: PRO edition name. */
				printf( esc_html__( 'Do more with %s', 'plogins-ticker' ), esc_html( $name ) );
				?>
				</strong>
				<?php
				if ( '' !== $subtitle ) :
					?>
					<span class="ticker-pro-banner__sub"><?php echo esc_html( $subtitle ); ?></span><?php endif; ?>
				<?php
				if ( '' !== $price ) :
					?>
					<span class="ticker-pro-banner__price"><?php echo esc_html( $price ); ?></span><?php endif; ?>
			</p>
			<a class="button button-primary ticker-pro-banner__cta" href="<?php echo esc_url( $this->url() ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Upgrade to PRO', 'plogins-ticker' ); ?>
			</a>
			<a class="ticker-pro-banner__dismiss" href="<?php echo esc_url( $this->dismissUrl() ); ?>" aria-label="<?php esc_attr_e( 'Dismiss this notice', 'plogins-ticker' ); ?>">&times;</a>
		</div>
		<?php
	}

	/**
	 * Render the sidebar promo panel (sits in the settings two-column layout).
	 */
	public function aside(): void {
		if ( ! $this->enabled() ) {
			return;
		}
		$name     = (string) ( $this->data()['name'] ?? 'Ticker Pro' );
		$price    = $this->priceLabel();
		$features = $this->features();
		?>
		<aside class="ticker-pro-aside" aria-labelledby="ticker-pro-aside-h">
			<p class="ticker-pro-aside__eyebrow"><?php echo esc_html( $name ); ?></p>
			<h2 id="ticker-pro-aside-h" class="ticker-pro-aside__heading"><?php esc_html_e( 'Unlock every PRO feature', 'plogins-ticker' ); ?></h2>
			<ul class="ticker-pro-aside__list">
				<?php foreach ( $features as $f ) : ?>
					<li>
						<span class="ticker-pro-aside__lock" aria-hidden="true"></span>
						<span><?php echo esc_html( $f['title'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<a class="button button-primary button-hero ticker-pro-aside__cta" href="<?php echo esc_url( $this->url() ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Upgrade to PRO', 'plogins-ticker' ); ?>
			</a>
			<?php if ( '' !== $price ) : ?>
				<p class="ticker-pro-aside__price"><?php echo esc_html( $price ); ?> · <?php esc_html_e( 'one licence, every PRO feature', 'plogins-ticker' ); ?></p>
			<?php endif; ?>
		</aside>
		<?php
	}

	/**
	 * Render the "What PRO adds" locked-card grid, appended after the form.
	 */
	public function cards(): void {
		if ( ! $this->enabled() ) {
			return;
		}
		$features = $this->features();
		$name     = (string) ( $this->data()['name'] ?? 'Ticker Pro' );
		?>
		<section class="ticker-pro-cards" aria-labelledby="ticker-pro-cards-h">
			<h2 id="ticker-pro-cards-h" class="ticker-pro-cards__title">
				<?php
				/* translators: %s: PRO edition name. */
				printf( esc_html__( 'What %s adds', 'plogins-ticker' ), esc_html( $name ) );
				?>
			</h2>
			<div class="ticker-pro-cards__grid">
				<?php foreach ( $features as $f ) : ?>
					<article class="ticker-pro-card">
						<span class="ticker-pro-card__badge">PRO</span>
						<span class="ticker-pro-card__lock" aria-hidden="true"></span>
						<h3 class="ticker-pro-card__title"><?php echo esc_html( $f['title'] ); ?></h3>
						<?php if ( '' !== $f['desc'] ) : ?>
							<p class="ticker-pro-card__desc"><?php echo esc_html( $f['desc'] ); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
