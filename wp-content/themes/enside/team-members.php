<?php
/**
 * Template part for displaying the Team Members section.
 *
 * Avatar images: drop Bitmoji (or any) PNG/WebP into img/team/ using the slug
 * filename, e.g. hafiz-umer-sheikh.png — same names as the bundled SVG placeholders.
 *
 * @package Enside
 */

$enside_team_members = array(
	array(
		'slug'     => 'hafiz-umer-sheikh',
		'name'     => 'Hafiz Umer Sheikh',
		'role'     => 'CEO',
		'linkedin' => 'https://www.linkedin.com/in/h-s-umer-farooq/',
	),
	array(
		'slug'     => 'muneeb-khan',
		'name'     => 'Muneeb Khan',
		'role'     => 'CTO',
		'linkedin' => 'https://www.linkedin.com/in/muneebjs/',
	),
	array(
		'slug'     => 'muhammad-memon',
		'name'     => 'Muhammad Memon',
		'role'     => '',
		'linkedin' => 'https://www.linkedin.com/company/boltay-huroof/people/',
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
					<a class="team-member-linkedin" href="<?php echo esc_url( $member['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'LinkedIn', 'enside' ); ?>
					</a>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
