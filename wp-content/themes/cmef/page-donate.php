<?php get_header();?>
	<div class="white-background page box-shadow donate">
		<div class="row">
			<div class="sixteen columns alpha omega">
				<div class="breadcrumbs">
				    <?php if(function_exists('bcn_display'))
				    {
				        bcn_display();
				    }?>
				</div>
			</div>
		</div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php $program = get_post(htmlspecialchars($_GET["program_id"])); //get the program for this donation page ?> 
		<?php 	if($program): 	// if the program exists then display donate page ?>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<h2 class="title"><?php the_title(); ?>: <?php echo $program->post_title ?></h2>
				<hr>
			</div>
		</div>
		
		<div class="row">
			<div class="sixteen columns alpha dontation-description">
				<p>Your donation will help supporting the cause. Thank You!</p>
			</div>
			<div class="eight columns alpha omega alert-messages">
				
			</div>
			<div class="clear"></div>
			<form action="" id="donation-form">
				<input type="hidden" name="thank_you_url" value="<?php echo add_query_arg('program_id', $program->ID, get_the_permalink(261)) ?>">
				<input type="hidden" name="program_id" value="<?php echo $program->ID ?>">
				<section>
					<div class="eight columns alpha">
						<h3>Contribution Amount</h3>
						<ul class="no-margin no-padding donation-amount">
							<li><input name="amount" type="radio" required="required" value="25.00">$25.00</li>
							<li><input name="amount" type="radio" required="required" value="50.00">$50.00</li>
							<li><input name="amount" type="radio" required="required" value="100.00">$100.00</li>
							<li><input name="amount" type="radio" required="required" value="250.00">$250.00</li>
							<li><input name="amount" type="radio" required="required" value="500.00">$500.00</li>
							<li><input name="amount" type="radio" required="required" value="1000.00">$1,000.00</li>
							<li><input name="amount" type="radio" required="required" value="other">Other Amount</li>
							<input type="text" name="otheramount" placeholder="Other Amount" disabled="disabled" value="">
						</ul>
					</div>
					<div class="eight coumns omega email">
						<section>
							<h3>Email Address</h3>
							<div class="eight columns alpha omega">
								<input type="text" name="email" placeholder="email@domain.com" required="required">
							</div>
						</section>
						<section>
							<div class="eight columns alpha omega">
								<input type="checkbox" name="organization_contribution"><label for="organization_contribution">I am contributing on behalf of an organization.</label>
							</div>
							<div class="eight columns alpha omega">
								<h3>Organization Name</h3>
								<input type="text" name="organization_name" placeholder="Organization Name" disabled="disabled">
								<!--<input type="checkbox" name="pay_for_transaction"><label for="pay_for_transaction">Pay For Credit Card Transaction</label>-->
								<br>
								<input type="checkbox" name="donate_to_cmef" checked="checked" value="5"><label for="donate_to_cmef">Donate $5.00 to CMEF</label>
							</div>
						</section>
					</div>
				</section>
				<div class="clear"></div>
				<div class="eight columns alpha">
					<section>
						<h3>Credit Card Information</h3>
						<!--<ul class="no-margin no-padding">
							<li><input type="radio" name="card_type" rrequired="required" value="Visa">Visa</li>
							<li><input type="radio" name="card_type" rrequired="required" value="mastercard">Mastercard</li>
						</ul>-->
						<input type="text" name="card_number" placeholder="Card Number" rrequired="required">
						<input type="text" name="three_digit" placeholder="Security Code" rrequired="required">
						<div class="three columns alpha">
						<h4>Expiration Month</h4>
							<select name="month" id="month" rrequired="required">

								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">June</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option> 
							</select>
						</div>
						<div class="three columns omega">
							<h4>Expiration Year</h4>
							<select name="credit_card_expiry_year" id="credit-card-expiration-year" rrequired="required">
							  <?php
							   for($i = date("Y"); $i < date("Y")+12; $i++){
							     echo "<option value='" . $i . "'>" . $i . "</option>";
							   }
							  ?>
							</select>
						</div>
						<div class="clear"></div>
						<div class="eight columns alpha omega card-logos">
							<div class="visa card"></div>
							<div class="mastercard card"></div>
							<div class="amex card"></div>
							<div class="discover card"></div>
						</div>
					</section>

				</div>
				<div class="eight columns omega">
					<h3>Billing Name and Address</h3>
					<input type="text" name="first_name" placeholder="First Name" rrequired="required">
					<input type="text" name="last_name" placeholder="Last Name" rrequired="required">
					<input type="text" name="street" placeholder="Street Address" rrequired="required">
					<input type="text" name="city" placeholder="City" rrequired="required">
					<div class="four columns alpha">
						<input type="text" name="zip" placeholder="Zip Code">
					</div>
					<div class="four columns omega">
						<label for="state">State</label>
						<select name="state" id="">
							<?php echo StateDropdown('', 'mixed'); ?>
						</select>
					</div>
					
				</div>
				<div class="eight offset-by-eight columns alpha omega">
					<div class="alignleft">
						<input type="checkbox" value="true" name="remain_anonymous"><label for="remain_anonymous">Remain Anonymous</label>
					</div>
					<div class="alignright"><h3>Total Donation: $<span id="total">5.00</span></h3></div>
				</div>
				<div class="clear"></div>
				<div class="sixteen columns alpha omega">
					<p><?php the_content(); ?></p>
					<input type="submit" class="button green alignright" value="Donate!">
				</div>
			</form>
		</div>
		<?php
			else:		//if the program does not exist then do not show donate form.
				echo 'Sorry This Program Does Not Exist.';
			endif;
		?>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>