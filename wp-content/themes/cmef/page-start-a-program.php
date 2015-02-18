<?php get_header();?>
	<div class="white-background page box-shadow">
		<div class="row">
	<div class="eight columns alpha omega alert-messages">
	
	</div>
	<div class="sixteen columns alpha omega" id="accordion">
			<?php if(!is_user_logged_in()): ?>
				<h3>Step 1: Register</h3>
				<form action="" id="register">
					<div class="eight columns alpha">
						<label><b>Username</b>
						<input class="margin-top-5" type="text" name="username" placeholder="Username *"></label>
						<label><b>Email Address</b>
						<input class="margin-top-5" required="required" type="text" name="email" placeholder="Email Address *"></label>
						<label><b>Confirm Email Address</b>
						<input class="margin-top-5" required="required" type="text" name="confirm_email" placeholder="Confirm Email Address *"></label>
					</div>
					<div class="sixteen columns alpha omega">
						<h3>Corps Member Profile</h3>
					</div>
					<div class="eight columns alpha">
						<label><b>First Name</b>
						<input class="margin-top-5" type="text" name="first_name" placeholder="First Name *"></label>
						<label><b>Last Name</b>
						<input class="margin-top-5" type="text" name="last_name" placeholder="Last Name *"></label>
						<label><b>Corps Region</b>
						<input class="margin-top-5" type="text" name="corp_region" placeholder="Corps Region *"></label>
						<label><b>Corps Year</b>
						<input class="margin-top-5" type="text" name="corp_year" placeholder="Corps Year *"></label>
						<label><b>Phone Number</b>
						<input class="margin-top-5" type="text" name="phone" placeholder="Phone Number *"></label>
					</div>
					<div class="eight columns omega">
						<label><b>Street Address 1</b>
						<input class="margin-top-5" type="text" name="street_1" placeholder="Street Address 1 *"></label>
						<label><b>Street Address 2</b>
						<input class="margin-top-5" type="text" name="street_2" placeholder="Street Address 2"></label>
						<label><b>City</b>
						<input class="margin-top-5" type="text" name="city" placeholder="City *"></label>
						<label><b>State</b>
						<input class="margin-top-5" type="text" name="state" placeholder="State *"></label>
						<label><b>Zip</b>
						<input class="margin-top-5" type="text" name="zip" placeholder="Zip *"></label>
					</div>
					<div class="sixteen columns alpha omega">
						<div class="button alignright green" id="submit-registration"><span class="button-text">Register</span></div>
					</div>
				</form>
			<?php endif; ?>
			<h3>Step <?php echo (is_user_logged_in() ? '1' : '2') ?>: Start a Program</h3>
			<form action="" id="new_program" data-user-id="<?php echo (is_user_logged_in() ? get_current_user_id() : '') ?>">
				<div class="sixteen columns alpha omega">
					<p><b>* Hint:</b> Try to limit the program name to 20 characters or less.</p>
					<div class="eight columns alpha">
						<b>Program Name</b>
						<input class="margin-top-5" type="text" name="program_name" placeholder="Program Name *">
						<b>Fundraising Goal</b>
						<input class="margin-top-5" type="text" name="fundraising_goal" placeholder="Fundraising Goal *">
						<b>Number of Students</b>
						<input class="margin-top-5" type="number" name="number_students" placeholder="Number of Students *">
						<b>School or Organization Name</b>
						<input class="margin-top-5" type="text" name="school_name" placeholder="School or Organization Name *">
					</div>
					<div class="eight columns omega">
					<b>Grade Level: </b>
					<div class="select margin-top-5">
						<?php 	$args = array(
									'order' => 'ASC',
									'hide_empty' => false
								);
						?>
						<?php $grade_levels = get_terms('grade-level', $args ) ?>
						<?php //print_r($grade_levels) ?>
						<select name="grade_level" id="grade-level">
							<?php foreach ($grade_levels as $grade_level) {
								echo '<option value="' . $grade_level->term_id . '">' . $grade_level->name . '</option>';
							} ?>
						</select>
					</div>
					<br>
					<b>TFA Region: </b>
					<div class="select margin-top-5">
						<?php 	$args = array(
									'order' => 'ASC',
									'hide_empty' => false
								);
						?>
						<?php $tfa_regions = get_terms('tfa-region', $args ) ?>
						<?php //print_r($grade_levels) ?>
						<select name="tfa_region" require="required">
							<?php foreach ($tfa_regions as $tfa_region) {
								echo '<option value="' . $tfa_region->term_id . '">' . $tfa_region->name . '</option>';
							} ?>
						</select>
					</div>
					<br>
					<b>Type of Program: </b>
					<div class="select margin-top-5">
						<?php 	$args = array(
									'order' => 'ASC',
									'hide_empty' => false
								);
						?>
						<?php $program_types = get_terms('program-type', $args ) ?>
						<?php //print_r($grade_levels) ?>
						<select name="program_type" require="required">
							<?php foreach ($program_types as $program_type) {
								echo '<option value="' . $program_type->term_id . '">' . $program_type->name . '</option>';
							} ?>
						</select>
					</div>
				</div>
				</div>
				
				<div class="sixteen columns alpha omega">
					<h3>Program Description</h3>
				</div>
				<div class="sixteen columns alpha omega">				
					<div class="new-program-description"></div>
					<br>
				</div>
				<div class="sixteen columns alpha omega">
					<div class="button green alignright" id="submit-new-program"><span class="button-text">Create Program</span></div>
				</div>
			</form>
			<h3>Step <?php echo (is_user_logged_in() ? '2' : '3') ?>: Upload Your Photos</h3>
			<form class="" action="<?php echo get_bloginfo('url') . '/wp-admin/admin-ajax.php' ?>?&action=upload_image"id="photo_upload" id="image_uploader" data-new-program-id="" enctype="multipart/form-data">
				<div class="sixteen columns alpha omega">
					<div class="eight columns alpha">
						<!--<img src="" alt="">-->
						
						<input type="file" name="image" class="image-uploader">
						<input type="text" placeholder="Choose File" class="image-uploader-placeholder" disabled="disabled">
						<div class="button green image-uploader-choose-file alignleft"><span>Choose File</span></div>
						<div class="button green image-uploader-button"><span class="button-text">Upload</span></div>
					</div>
					<div class="eight columns omega uploaded-images">
						
					</div>
					<div class="sixteen columns alpha omega">
						<br>
						<b>Hint:</b>
						<p>Click on one of your uploaded images to make it your program's cover image.</p>
					</div>
					<div class="sixteen columns alpha omega">
						<a class="button green alignright program-complete"><span>Finished</span></a>
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>
<?php get_footer(); ?>