<template>
	<div>
		<section-content>
		   <visita typevisita="1"/>
		</section-content>
	</div>
</template>
<script>
	import SectionContent from "@/components/SectionContent.vue"
	import Visita from '@/components/Visitas/Visita.vue';

	import {mapGetters} from 'vuex';
	export default {
		components: {
	      SectionContent,Visita
	    }
	}
</script>