<?php
/**
 * @file
 * Cost-quantity component's template
 */
?>
<div :style="additionalCss" class="calc-item" :class="rangeField.additionalStyles" :data-id="rangeField.alias" >
	<div class="calc-range" :class="['calc_' + rangeField.alias, {'calc-field-disabled': getStep === 'finish'}]">
		<div class="calc-item__title ccb-range-field" style="display: flex; justify-content: space-between">
			<span> {{ rangeField.label }} </span>
			<span> {{ getFormatedValue }} {{ rangeField.sign ? rangeField.sign : '' }}</span>
		</div>

		<div class="calc-item__description before">
			<span>{{ rangeField.description }}</span>
		</div>

		<div :class="['range_' + rangeField.alias]" class="calc-range-slider" :style="getStyles">
			<input type="range" :min="min" :max="max" :step="step" v-model="rangeValue" @input="change">
			<output class="cost-calc-range-output-free"></output>
			<div class='calc-range-slider__progress'></div>
		</div>

		<div class="calc-range-slider-min-max">
			<span>{{ min }}</span>
			<span>{{ max }}</span>
		</div>

		<div class="calc-item__description after" >
			<span>{{ rangeField.description }}</span>
		</div>
	</div>
</div>
