<template>
	<div>
		<section-content>
			<div class="card">
				<div class="card-body">
				   <div class="row">
				   		<div class="col-12 text-center">
				   			<h1>Error 404</h1>
				   		</div>


				   </div>
				   <hr>
				   <div class="row">
				   		<div class="text-center col-12">
				   			<img :src="pathimg" alt="" class="w-25">
				   		</div>
				   </div>
				   <hr>
				   <div class="row">
				   		<div class="col-12 text-center">
				   			<h3>Ooops! Tenemos un error, Pagina no encontrada o no tiene los privilegios para acceder</h3>
				   		</div>
				   </div>
				   <hr>
			   </div>
		   </div>
		</section-content>
	</div>
</template>
<script>
	import SectionContent from "@/components/SectionContent.vue"

	export default {
		components: {
	      SectionContent
	    },
	    data(){
	    	return{
	    		pathimg:null
	    	}
	    },
	    created(){
	    	this.pathimg = `${base_path_asset}/img/error.png`
	    }

	};
</script>
<style scoped>
	h1{
		font-size: 130px;
		color: #2e636b;
	}
	h3{
		color: #1b170e9e;
	}
</style>