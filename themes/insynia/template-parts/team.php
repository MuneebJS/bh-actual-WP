<?php
/**
 * Team members section.
 *
 * @package BH_Starter
 */

$bh_team = array(
	array(
		'slug'     => 'hafiz-umer-sheikh',
		'name'     => 'Hafiz Umer Sheikh',
		'role'     => 'Co-founder & CEO',
		'linkedin' => 'https://www.linkedin.com/in/h-s-umer-farooq/',
	),
	array(
		'slug'     => 'muneeb-khan',
		'name'     => 'Muneeb Khan',
		'role'     => 'CTO',
		'linkedin' => 'https://www.linkedin.com/in/muneebjs/',
	),
	array(
		'slug'     => 'shafia-abdul-latif',
		'name'     => 'Shafia Abdul Latif',
		'role'     => 'CMO',
		'linkedin' => '',
	),
	array(
		'slug'     => 'shah-bakht-bin-saeed',
		'name'     => 'Shah Bakht Bin Saeed',
		'role'     => 'Head BD',
		'linkedin' => '',
	),
	array(
		'slug'     => 'saud-ahmed',
		'name'     => 'Saud Ahmed',
		'role'     => 'Quality Assurance',
		'linkedin' => '',
	),
);
?>

<section class="team-section bh-section" id="team">
	<div class="bh-container">

		<div class="section-header">
			<span class="section-label"><?php esc_html_e( 'Our People', 'bh-starter' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Meet Our Team', 'bh-starter' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'The passionate people behind our mission to make the world more accessible.', 'bh-starter' ); ?></p>
		</div>

		<div class="team-grid">
			<?php foreach ( $bh_team as $i => $member ) :
				$avatar = function_exists( 'bh_starter_team_avatar_url' )
					? bh_starter_team_avatar_url( $member['slug'] )
					: get_template_directory_uri() . '/assets/img/team/' . $member['slug'] . '.svg';
			?>
				<div class="team-card">
					<div class="team-avatar">
						<img
							src="<?php echo esc_url( $avatar ); ?>"
							alt="<?php echo esc_attr( $member['name'] ); ?>"
							width="120"
							height="120"
							loading="lazy"
							decoding="async"
						>
					</div>
					<h3 class="team-name"><?php echo esc_html( $member['name'] ); ?></h3>
					<?php if ( '' !== trim( $member['role'] ) ) : ?>
						<p class="team-role"><?php echo esc_html( $member['role'] ); ?></p>
					<?php else : ?>
						<p class="team-role">&nbsp;</p>
					<?php endif; ?>
					<?php if ( ! empty( $member['linkedin'] ) ) : ?>
					<a class="team-linkedin" href="<?php echo esc_url( $member['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
						<?php esc_html_e( 'LinkedIn', 'bh-starter' ); ?>
					</a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
