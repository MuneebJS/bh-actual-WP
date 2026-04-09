<?php
/**
 * Template part for displaying the Team Members section.
 *
 * Avatar images: PNG, WebP, or JPEG in img/team/ named {slug}.ext (see $enside_team_members).
 *
 * @package Enside
 */

$enside_team_members = array(
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
<section class="team-section content-block" id="team">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 class="team-section-title"><?php esc_html_e( 'Meet Our Team', 'enside' ); ?></h2>
			</div>
		</div>
		<div class="row team-members-row">
			<?php foreach ( $enside_team_members as $member ) : ?>
				<?php
				$avatar_url = function_exists( 'enside_team_member_avatar_url' )
					? enside_team_member_avatar_url( $member['slug'] )
					: get_template_directory_uri() . '/img/team/' . $member['slug'] . '.svg';
				?>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="team-member text-center">
					<div class="team-member-avatar-wrap">
						<img
							class="team-member-bitmoji"
							src="<?php echo esc_url( $avatar_url ); ?>"
							alt="<?php echo esc_attr( $member['name'] ); ?>"
							width="200"
							height="200"
							loading="lazy"
							decoding="async"
						/>
					</div>
					<h4 class="team-member-name"><?php echo esc_html( $member['name'] ); ?></h4>
					<?php if ( '' !== trim( $member['role'] ) ) : ?>
					<p class="team-member-role"><?php echo esc_html( $member['role'] ); ?></p>
					<?php else : ?>
					<p class="team-member-role team-member-role-empty" aria-hidden="true">&nbsp;</p>
					<?php endif; ?>
					<?php if ( ! empty( $member['linkedin'] ) ) : ?>
					<a class="team-member-linkedin" href="<?php echo esc_url( $member['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'LinkedIn', 'enside' ); ?>
					</a>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
