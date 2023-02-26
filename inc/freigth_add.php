<?php
/**
 *
 * @author    balconet.co
 * @package   Tigon
 * @version   1.0.0
 * @since     1.0.0
 */

add_action( 'wp_enqueue_scripts', 'freighty_add_scripts_loader' );
function freighty_add_scripts_loader() {
	wp_enqueue_style( 'stm_add_a_car_steps', get_stylesheet_directory_uri() . '/assets/css/add_a_car_steps.css', [], time() );
	wp_enqueue_script( 'stm_add_a_car_steps', get_stylesheet_directory_uri() . '/assets/js/add_a_car_steps.js', [ 'jquery' ], time() );

}

// Instant Cash Offer Form
function instant_cash_offer_form_shortcode( $atts ) {

	ob_start();
	$id        = get_current_user_id();
	$firstname = get_user_meta( $id, 'first_name', true );
	$lastname  = get_user_meta( $id, 'last_name', true );
	$phone     = get_user_meta( $id, 'stm_phone', true );
	?>
	<div class="my-form">
		<form id="freight-form">
			<ul class="fl-progress-bar">
				<li class="active"><?php esc_html_e( 'Step 1', 'freigty' ); ?></li>
				<li><?php esc_html_e( 'Step 2', 'freigty' ); ?></li>
				<li><?php esc_html_e( 'Step 3', 'freigty' ); ?></li>
				<li><?php esc_html_e( 'Step 4', 'freigty' ); ?></li>
				<li><?php esc_html_e( 'Step 5', 'freigty' ); ?></li>
			</ul>
			<fieldset class="step-1 current fieldset">
				<legend><h2><?php esc_html_e( 'Choose category and cargo type', 'freigty' ); ?></h2></legend>
				<?php echo do_shortcode( '[freight_taxonomy_list]' ); ?>
				<div class="row-button freight-type-button-row">
					<button class="freight-back-button"><?php esc_html_e( 'Back', 'freigty' ); ?></button>
				</div>
			</fieldset>

			<fieldset class="step-2 fieldset">
				<legend><?php esc_html_e( 'Step 2', 'freigty' ); ?></legend>

				<div>
					<label for="length"><?php esc_html_e( 'Length:', 'freigty' ); ?></label>
					<input type="number" id="length" name="length">
				</div>
				<div>
					<label for="width"><?php esc_html_e( 'Width:', 'freigty' ); ?></label>
					<input type="number" id="width" name="width">
				</div>
				<div>
					<label for="height"><?php esc_html_e( 'Height:', 'freigty' ); ?></label>
					<input type="number" id="height" name="height">
				</div>
				<div>
					<label for="weight"><?php esc_html_e( 'Weight:', 'freigty' ); ?></label>
					<input type="number" id="weight" name="weight">
				</div>
				<div>
					<label for="quantity"><?php esc_html_e( 'Quantity:', 'freigty' ); ?></label>
					<input type="number" id="quantity" name="quantity">
				</div>
				<div>
					<label for="image"><?php esc_html_e( 'Upload image:', 'freigty' ); ?></label>
					<input type="file" id="image" name="image">
				</div>

				<div>
					<button type="button" onclick="calculate()"><?php esc_html_e( 'Calculate', 'freigty' ); ?></button>
				</div>
				<div>
					<label for="volume"><?php echo __( 'Volume:', 'freigty' ); ?></label>
					<span id="volume-value"><?php echo __( '0.00 М³', 'freigty' ); ?></span>
				</div>
				<div>
					<label for="total-volume"><?php echo __( 'Total Volume', 'freigty' ); ?></label>
					<span id="total-volume-value"><?php echo __( '0.00 М³', 'freigty' ); ?></span>
				</div>
				<div>
					<label for="total-weight"><?php echo __( 'Total Weight:', 'freigty' ); ?></label>
					<span id="total-weight-value"><?php echo __( '0.00 Kg', 'freigty' ); ?></span>
				</div>

				<div class="row-button">
					<button type="button" class="back-button"><?php echo __( 'Назад', 'freigty' ); ?></button>
					<button type="button" class="continue-button"><?php echo __( 'Далее', 'freigty' ); ?></button>
				</div>
			</fieldset>
			<fieldset class="step-3 fieldset">
				<legend><?php echo __( 'Шаг 3', 'freigty' ); ?></legend>
				<?php echo do_shortcode( '[contact-form-7 id="5" title="' . __( 'Kaрта', 'freigty' ) . '"]' ); ?>
				<div class="row-button">
					<button type="button" class="back-button"><?php echo __( 'Назад', 'freigty' ); ?></button>
					<button type="button" class="continue-button"><?php echo __( 'Далее', 'freigty' ); ?></button>
				</div>
			</fieldset>
			<fieldset class="step-4 fieldset">
				<legend><?php echo __( 'Шаг 4', 'freigty' ); ?></legend>
				<label for="message"><?php echo __( 'Дополнительное информация о грузе:', 'freigty' ); ?></label>
				<textarea id="message" row="3" placeholder="<?php echo __( 'Здесь вы можете добавить нюансы и особенности вашей перевозки: сопровождение груза; документы на груз; таможенное прохождение; доп. условие по машине; перевозка животных и т. д.', 'freigty' ); ?>" name="freight_info"
						  class="input-field"></textarea>
				<span class="stm-error"></span>
				<div class="row-button">
					<button type="button" class="back-button"><?php echo __( 'Назад', 'freigty' ); ?></button>
					<button type="button"  class="show-final-button freight-back-button"  id="show-final-button"><?php echo __( 'Next', 'freigty' ); ?></div>
			</fieldset>
			<fieldset class="step-5 fieldset">
				<legend><?php echo __( 'Шаг 5', 'freigty' ); ?></legend>
				<h2 class="freight_info" ><?php echo __( 'Freight Iinfo:', 'freigty' ); ?></h2>
				<div class="final_freight_info" id="final_freight_info"></div>
				<div class="row-button">
					<button type="button" class="back-button"><?php echo __( 'Назад', 'freigty' ); ?></button>
					<input type="submit" value="<?php echo __( 'Submit', 'freigty' ); ?>" class="submit-button"></div>
			</fieldset>
		</form>
	</div>


	<?php
	wp_reset_postdata();
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'instant_cash_offer_form', 'instant_cash_offer_form_shortcode' );
