<template>
	<div>
		<!-- Modal -->
		<modal :showModal="showModal">
			<template v-slot:header>
			    {{tipemessage}} 
			</template>
		    <errors-form :errors="validationForm"/>
			<success-message :message="message_success"/>
			<form action="" @submit.prevent="formsave">
				<div class="row">
					<div class="col-6">
						<label for="">Nombres</label>
						<input type="text" required="" v-model="form.nombres" class="form-control" placeholder="Ingrese sus nombres"> 
					</div>
					<div class="col-6">
						<label for="">Apellidos</label>
						<input type="text" required="" v-model="form.apellidos" class="form-control" placeholder="Ingrese sus apellidos">
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-6">
						<label for="">Razón social</label>
						<input type="text" required="" v-model="form.nsocial" class="form-control" placeholder="Ingrese su razón social">
					</div>
					<div class="col-6">
						<label for="">Identificación</label>
						<input type="text" required="" v-model="form.identificacion" class="form-control" placeholder="Ingrese su identificacion">
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-12">
						<input type="text" v-model="form.direccion" class="form-control" placeholder="Ingrese su dirección completa">
					</div>
				</div>
				<hr>
				<div class="row mt-2">
					<div class="col-12 text-center">
						<button class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
					</div>
				</div>
			</form>
		</modal>
	</div>
</template>
<script>
	import Modal from '@/components/Modal.vue';
	import ErrorsForm from "@/components/ValidationErrors.vue"
	import successMessage from '@/components/SuccessMessage';
	export default {
		props:['form','tipe','urlform','tipemessage','validation','showModal'],

		components: {
	      Modal,successMessage,ErrorsForm
	    },

	    data: function() {
	    	return {
	    		validationForm:[],
	    		message_success:'',
	    		fullPage: false
	    	}
	    },
	    methods:{
	    	clearform(){
        		let me = this;
        		Object.keys(this.form).forEach(function(key) {
        		  if (Array.isArray(me.form[key]) ) {
        		  	me.form[key] = []
        		  }else{
				  	me.form[key] = '';
				  }
				})
        	},
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
	    	formsave(){
	    		let loader = this.loader();
	    		let me = this;
	    		this.message_success = ''

	    		axios.post(this.urlform,this.form).then((response) => {
	    			me.validationForm = ''
	    			if (me.tipe == 'create') {
	    				me.clearform()
	    			}
	    		    me.message_success = response.data.success
	    		    $('#table_id').DataTable().ajax.reload();

	    		    loader.hide()
	    		    me.resetmessage();

	    		}).catch((error) => {
	    			loader.hide()
	    			me.validationForm = ''
	    		  	if (error.response.status == 422){
			    		me.validationForm = error.response.data;
			      	}else if (error.response.status == 500) {
			        	alert(error.response.data.message)
			      	}
	    		})
	    	}
	    }
	}

</script>