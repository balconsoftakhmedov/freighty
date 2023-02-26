<?php
$export_link = esc_url( get_site_url() ) . '/wp-admin/admin-ajax.php?action=cost-calculator-custom_export_run&ccb_nonce=' . esc_attr( wp_create_nonce( 'ccb-export-nonce' ) );
$modal_types = array(
	'quick-tour' => array(
		'type' => 'quick-tour',
		'path' => CALC_PATH . '/templates/admin/single-calc/modals/quick-tour-start.php',
	),
);
?>

<div class="ccb-table-body" style="height: calc(100vh - 145px)" v-if="preloader">
	<loader></loader>
</div>
<div class="ccb-table-body" style="height: calc(100vh - 145px)" v-else>
	<div class="ccb-table-body--card" v-if="getExisting?.length > 0 || calculatorsList.page > 1">

		<div class="table-display">
			<div class="table-display--left">
				<div class="ccb-bulk-actions">
					<div class="ccb-select-wrapper">
						<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
						<select name="actionType" id="actionType" class="ccb-select">
							<option value="-1"><?php esc_html_e( 'Bulk actions', 'cost-calculator-builder' ); ?></option>
							<option value="duplicate" class="hide-if-no-js"><?php esc_html_e( 'Duplicate', 'cost-calculator-builder' ); ?></option>
							<option value="delete"><?php esc_html_e( 'Delete', 'cost-calculator-builder' ); ?></option>
						</select>
					</div>
					<button class="ccb-button default" @click.prevent="bulkAction"><?php esc_html_e( 'Apply', 'cost-calculator-builder' ); ?></button>
				</div>
			</div>
			<div class="table-display--right">
				<div class="ccb-bulk-actions">
					<button class="ccb-button default" @click="openDemoImport">
						<i class="ccb-icon-Path-34581" style="margin-right: 3px"></i>
						<?php esc_html_e( 'Import', 'cost-calculator-builder' ); ?>
					</button>
					<a class="ccb-button ccb-href default" :class="{disabled: !getExisting.length}" href="<?php echo esc_url( $export_link ); ?>">
						<i class="ccb-icon-Path-3458" style="margin-right: 3px"></i>
						<?php esc_html_e( 'Export', 'cost-calculator-builder' ); ?>
					</a>
					<button class="ccb-button success" @click.prevent="createId">
						<i class="ccb-icon-Path-3453" style="margin-right: 3px"></i>
						<?php esc_html_e( 'Create new', 'cost-calculator-builder' ); ?>
					</button>
				</div>
			</div>
		</div>
		<div class="table-concept ccb-custom-scrollbar">
			<div class="list-item calculators-header calculators">
				<div class="list-title check">
					<input type="checkbox" v-model="allChecked" @click="checkAllCalculatorsAction">
				</div>
				<div class="list-title sortable id" :class="isActiveSort('id')" @click="setSort('id')">
					<span class="ccb-default-title"><?php esc_html_e( 'ID', 'cost-calculator-builder' ); ?></span>
				</div>
				<div class="list-title sortable title" :class="isActiveSort('post_title')" @click="setSort('post_title')">
					<span class="ccb-default-title"><?php esc_html_e( 'Calculator Name', 'cost-calculator-builder' ); ?></span>
				</div>
				<div class="list-title actions <?php echo esc_attr( 'actions' ); ?>" style="text-align: right">
					<span class="ccb-default-title"><?php esc_html_e( 'Actions', 'cost-calculator-builder' ); ?></span>
				</div>
			</div>
			<div class="list-item calculators" v-for="(calc, idx) in getExisting" :key="idx">
				<div class="list-title check">
					<input type="checkbox" :checked="checkedCalculatorIds.includes(calc.id)" :value="calc.id" @click="checkCalculatorAction(calc.id)">
				</div>
				<div class="list-title id">
					<span class="ccb-default-title">{{ calc.id }}</span>
				</div>
				<div class="list-title title">
					<span class="ccb-title">
						<span class="ccb-default-title" style="cursor: pointer" @click="editCalc(calc.id)">{{ calc.project_name | to-short }}</span>
					</span>
				</div>
				<div class="list-title actions" style="display: flex; justify-content: flex-end">
					<div class="ccb-action copy" @click="embedCalc(calc.id)">
						<i class="ccb-icon-html"></i>
						<span><?php echo esc_html__( 'Embed', 'cost-calculator-builder' ); ?></span>
					</div>
					<div class="ccb-action copy" @click="duplicateCalc(calc.id)">
						<i class="ccb-icon-Path-3505"></i>
						<span><?php echo esc_html__( 'Dublicate', 'cost-calculator-builder' ); ?></span>
					</div>
					<div class="ccb-action delete" @click="deleteCalc(calc.id)">
						<i class="ccb-icon-Path-3503"></i>
						<span><?php echo esc_html__( 'Delete', 'cost-calculator-builder' ); ?></span>
					</div>
					<div class="ccb-action edit"  @click="editCalc(calc.id)">
						<i class="ccb-icon-Path-3483"></i>
						<span><?php echo esc_html__( 'Edit', 'cost-calculator-builder' ); ?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="ccb-pagination">
			<div class="ccb-pages">
				<span class="ccb-page-item" @click="prevPage" v-if="calculatorsList.page != 1">
					<i class="ccb-icon-Path-3481 prev"></i>
				</span>
				<span class="ccb-page-item" v-for="n in totalPages" :key="n" :class="{active: n === calculatorsList.page}" @click="getPage(n)" :disabled="n == calculatorsList.page">{{ n }}</span>
				<span class="ccb-page-item" @click="nextPage" v-if="calculatorsList.page != totalPages">
					<i class="ccb-icon-Path-3481"></i>
				</span>
			</div>
			<div class="ccb-bulk-actions">
				<div class="ccb-select-wrapper">
					<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
					<select v-model="limit" @change="resetPage" class="ccb-select">
						<option value="5"><?php esc_html_e( '5 calculators per page', 'cost-calculator-builder' ); ?></option>
						<option value="10" class="hide-if-no-js"><?php esc_html_e( '10 calculators per page', 'cost-calculator-builder' ); ?></option>
						<option value="15" class="hide-if-no-js"><?php esc_html_e( '15 calculators per page', 'cost-calculator-builder' ); ?></option>
						<option value="20"><?php esc_html_e( '20 calculators per page', 'cost-calculator-builder' ); ?></option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="ccb-no-existing-calc ccb-demo-import-container" style="width: 100%" v-else>
		<div class="ccb-demo-import-content ccb-quick-tour-no-calculators">
			<div class="ccb-demo-import-icon-wrap">
				<i class="ccb-icon-Union-32"></i>
			</div>
			<div class="ccb-demo-import-title">
				<span><?php esc_html_e( 'No calculators yet', 'cost-calculator-builder' ); ?></span>
			</div>
			<div class="ccb-demo-import-description">
				<span><?php esc_html_e( 'Create a new one from scratch or import prebuilt calculators.', 'cost-calculator-builder' ); ?></span>
			</div>
			<div class="ccb-demo-import-action">
				<button class="ccb-button default" :class="{disabled: $store.getters.getQuickTourStep !== 'done'}" @click="openDemoImport"><?php esc_html_e( 'Prebuilt Calculators' ); ?></button>
				<button class="ccb-button success" @click.prevent="createId">
					<i class="ccb-icon-Path-3453" style="margin-right: 3px;"></i>
					<?php esc_html_e( 'Create', 'cost-calculator-builder' ); ?>
				</button>
			</div>
		</div>
	</div>
	<?php if ( 'done' !== get_option( 'ccb_quick_tour_type', 'quick_tour_start' ) ) : ?>
		<ccb-modal-window v-if="getExisting?.length === 0">
			<template v-slot:content>
				<ccb-quick-tour
						@start-quick-tour="startQuickTour"
						inline-template
				>
					<?php require_once CALC_PATH . '/templates/admin/single-calc/modals/quick-tour-start.php'; ?>
				</ccb-quick-tour>
			</template>
		</ccb-modal-window>
	<?php endif; ?>
</div>
