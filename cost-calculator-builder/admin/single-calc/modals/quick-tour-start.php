<div class="modal-body ccb-quick-tour-start">
	<div class="ccb-demo-import-container">
		<div class="ccb-demo-import-content">
			<div class="ccb-demo-import-icon-wrap">
				<img class="calc-logo" src="<?php echo esc_url( CALC_URL . '/frontend/dist/img/calc.png' ); ?>" alt="">
			</div>
			<div class="ccb-demo-import-title">
				<span><?php esc_html_e( 'Greetings, and Welcome to Cost Calculator!', 'cost-calculator-builder' ); ?></span>
			</div>
			<div class="ccb-demo-import-description">
				<span><?php esc_html_e( 'Create and Set up a calculator for your services to grow your business.', 'cost-calculator-builder' ); ?></span>
			</div>
			<div class="ccb-demo-import-action">
				<button class="ccb-button success" @click="quickTourNextStep">
					<?php esc_html_e( 'Create your first calculator', 'cost-calculator-builder' ); ?>
				</button>
			</div>
		</div>
	</div>
	<button class="ccb-button skip" @click="skipAndClose">
		<?php esc_html_e( 'Skip & not show me again', 'cost-calculator-builder' ); ?>
	</button>
</div>
