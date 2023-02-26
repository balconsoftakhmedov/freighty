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
	<div class="my-form" method="get" action="post.php">
		<ul class="fl-progress-bar">
			<li class="active"> Шаг 1</li>
			<li>Шаг 2</li>
			<li>Шаг 3</li>
			<li>Шаг 4</li>
			<li>Шаг 5</li>

		</ul>
		<fieldset class="step-1 current fieldset">
			<legend><h2>Выберите категорию и тип груза</h2></legend>
			<?php echo do_shortcode( '[freight_taxonomy_list]' ); ?>
			<div class="row-button freight-type-button-row">
				<button class="freight-back-button">Назад</button>

			</div>

		</fieldset>

		<fieldset class="step-2 fieldset">
			<legend>Шаг 2</legend>
			<form>
				<div>
					<label for="length">Длина:</label>
					<input type="number" id="length" name="length" required>
				</div>
				<div>
					<label for="width">Ширина:</label>
					<input type="number" id="width" name="width" required>
				</div>
				<div>
					<label for="height">Высота:</label>
					<input type="number" id="height" name="height" required>
				</div>
				<div>
					<label for="weight">Вес:</label>
					<input type="number" id="weight" name="weight" required>
				</div>
				<div>
					<label for="quantity">Количество:</label>
					<input type="number" id="quantity" name="quantity" required>
				</div>
				<div>
					<label for="image">Загрузите изображение:</label>
					<input type="file" id="image" name="image">
				</div>
				<div>
					<button type="button" onclick="calculate()">Рассчитать</button>
				</div>
				<div>
					<label for="volume">Объём:</label>
					<span id="volume-value">0.00 М³</span>
				</div>
				<div>
					<label for="total-volume">Общий Объем:</label>
					<span id="total-volume-value">0.00 М³</span>
				</div>
				<div>
					<label for="total-weight">Общий Вес:</label>
					<span id="total-weight-value">0.00 Кг</span>
				</div>
			</form>

			<div class="row-button">
				<button type="button" class="back-button">Назад</button>
				<button type="button" class="continue-button">Далее</button>
			</div>
		</fieldset>
		<fieldset class="step-3 fieldset">
			<legend>Шаг 3</legend>
			<?php echo do_shortcode( '[contact-form-7 id="5" title="Kaрта"]' ); ?>
			<div class="row-button">
				<button type="button" class="back-button">Назад</button>
				<button type="button" class="continue-button">Далее</button>
			</div>
		</fieldset>
		<fieldset class="step-4 fieldset">
			<legend>Шаг 4</legend>
			<label for="phone">Phone:</label>
			<input type="tel" id="phone" name="phone" class="input-field">
			<span class="stm-error"></span>
			<label for="message">Message:</label>
			<textarea id="message" name="message" class="input-field"></textarea>
			<span class="stm-error"></span>
			<div class="row-button">
				<button type="button" class="back-button">Назад</button>
				<button type="button" class="continue-button">Далее</button>
			</div>
		</fieldset>
		<fieldset class="step-5 fieldset">
			<legend>Шаг 5</legend>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" class="input-field">
			<span class="stm-error"></span>
			<label for="confirm-password">Confirm Password:</label>
			<input type="password" id="confirm-password" name="confirm-password" class="input-field">
			<span class="stm-error"></span>
			<div class="row-button">
				<button type="button" class="back-button">Назад</button>
				<input type="submit" value="Submit" class="submit-button"></div>
		</fieldset>
	</div>


	<?php
	wp_reset_postdata();
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'instant_cash_offer_form', 'instant_cash_offer_form_shortcode' );
