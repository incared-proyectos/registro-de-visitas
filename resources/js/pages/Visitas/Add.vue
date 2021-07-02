<template>
	<div>
		<section-content>
		    <!-- Main row -->
		    <div class="row">
		    	<div class="col-12">
			     	<div class="card">
			     	   <div class="card-header bg bg-info">
			     	   		<div class="row">
			     	   			<div class="col-6">
			     	   				<b><i class="fas fa-eye"></i>  <i class="fas fa-plus-square"></i>  Formulario Visita</b>
			     	   			</div>
			     	   			<div class="col-6 text-right">
			     	   				<router-link  to="/visitas" class="text-white">
				                        <b><i class="fas fa-arrow-alt-circle-left"></i> Volver al listado..</b>
				                    </router-link>
			     	   			</div>
			     	   		</div>
			     	   </div>
		              <div class="card-body">
					    <errors-form :errors="validationForm"/>
						<success-message :message="message_success"/>

		              	<form action="" @submit.prevent="saveform">
		              		<!--Inputs selects y otros en un componente llamado head-form-->
		              		<head-form 
			              		:form="form"

			              		@nombre="form.nombre = $event"
								@dni="form.dni = $event"
								@itemjson="form.itemsjson = $event"
								@lugar="form.lugar = $event"
		              		/>

		              		<!--Componente para tomar la foto mediante un modal -->
		              		<foto-modal
		              		:form="form"
		              		/>

		              		<div class="row mt-3">
		              			<div class="col-12 text-center">
		              				<button class="btn btn-primary" ><i class="fas fa-save"></i> Guardar</button>
		              			</div>
		              		</div>
		              	</form>

		              </div>
		            </div>
		     	</div>
		    </div>
		    <!-- /.row (main row) -->
		</section-content>

	</div>
</template>
<script>
	import SectionContent from "@/components/SectionContent.vue"
	import HeaderTitle from "@/components/HeaderTitle.vue"
	import HeadForm from "@/components/visitas/head.vue"
	import FotoModal from "@/components/visitas/FotoModal.vue"
	import ErrorsForm from "@/components/ValidationErrors.vue"
	import successMessage from '@/components/SuccessMessage.vue';

	export default {
		components:{
			SectionContent,HeaderTitle,HeadForm,FotoModal,successMessage,ErrorsForm
		},
		data: function() {
			return {
				form:{
					nombre:'',
					dni:'',
					lugar:'',
					srcfoto:null,
					itemsjson:null,
				},
				validationForm:[],
	    		message_success:'',
	    		fullPage: false
			}

		},
		methods:{
			loader(){
	    		return this.$loading.show({
                  // Optional parameters
                  container: this.fullPage ? null : this.$refs.formContainer,
                  canCancel: false,
                  onCancel: this.onCancel,
                });
	    	},
	    	resetmessage(){
	    		let me =  this;
	    		setTimeout(function(){ me.message_success = '' ;me.validationForm = [];}, 7000);
	    	},
	    	clearform(){
        		let me = this;
        		Object.keys(this.form).forEach(function(key) {
        		  if (Array.isArray(me.form[key]) ) {
        		  	me.form[key] = []
        		  }else{
				  	me.form[key] = null;
				  }
				})
        	},
        
			saveform(){
				let loader = this.loader();
	    		let me = this;
	    		this.message_success = ''

				axios.post(route('visitas.create'),this.form)
			  	.then(function (response) {

			  		me.validationForm = ''
	    		    me.message_success = response.data.success
	    		    me.clearform();
	    		    location.href = response.data.url
			    	
			  	})
			  	.catch(function (error) {
			    	loader.hide()
	    			me.validationForm = ''
	    		  	if (error.response.status == 422){
			    		me.validationForm = error.response.data;
			      	}else if (error.response.status == 500) {
			        	alert(error.response.data.message)
			      	}
			  	});
			}
		},
		mounted(){

		}

	}



</script>