<template>
	<div>
		<div class="row">
  			<div class="col-4">
  				<label for="" class="text-uppercase">Nombre y Apellido</label>
  				<input type="text"  placeholder="Escribe tu nombre y Apellido" class="form-control" :value="form.nombre"  @input="$emit('nombre', $event.target.value)" required="">
  			</div>
  			<div class="col-4">
  				<label for="" class="text-uppercase">DNI</label>
  				<input type="text"  placeholder="Identificacion" class="form-control" :value="form.dni"  @input="$emit('dni', $event.target.value)" required="">
  			</div>
  			<div class="col-4">
  				<label for="" class="text-uppercase">Entidad</label>
  				<br>
				<select class="form-control jsoninput"  data-name="entidad" data-live-search="true" @change="jsonform"  required="" >
  					<option value="">Seleccionar Entidad...</option>
  					<option v-for="item in entidad"  
  					:key="item.id" 
  					:data-name="item.nsocial" 
  					:data-id="item.id"
					:selected="item.id == jsonselects.entidad.id"

  					>
  						{{item.nombres}} || {{item.apellidos}}
  					</option>
  				</select>
  			</div>
  		</div>
  		<hr>
  		<div class="row">
  			<div class="col-4">
  				<label for="" class="text-uppercase">Motivo</label>
  				<select name="motivo" class="form-control jsoninput" data-name="motivo"   data-live-search="true"  @change="jsonform" required="" >
  					<option value="">Seleccionar Motivo...</option>
  					<option v-for="item in motivos"  
  					:key="item.id"
  					:data-name="item.motivo" 
  					:data-id="item.id"
  					:selected="item.id == jsonselects.motivo.id"

  					>
  						{{item.motivo}}
  					</option>
  				</select>
  			</div>
  			<div class="col-4">
  				<label for="" class="text-uppercase">Empleado</label>
  				<select name="empleado" class="form-control jsoninput" data-name="empleado"   data-live-search="true" @change="jsonform" required="">
  					<option value="">Seleccionar Empleado...</option>
  					<option v-for="item in empleados" 
  					:key="item.id" 
  					:data-name="item.name" 
  					:data-id="item.id"
  					:selected="item.id == jsonselects.empleado.id"

  					>
  						{{item.name}}
  					</option>
  				</select>
  			</div>
  			<div class="col-4">
  				<label for="" class="text-uppercase">Sedes</label>
  				<select name="sede" class="form-control jsoninput"  data-name="sede" data-live-search="true" @change="jsonform" required="">
  					<option value="">Seleccionar Sede...</option>
  					<option v-for="item in sedes"   
  					:key="item.id" 
  					:data-name="item.sede" 
  					:data-id="item.id"
  					:selected="item.id == jsonselects.sede.id">
  						{{item.sede}}
  					</option>
  				</select>
  			</div>
  		</div>
  		<hr>
  		<div class="row">
  			<div class="col-4">
  				<input type="text" :value="form.lugar"  @input="$emit('lugar', $event.target.value)" class="form-control" placeholder="Lugar de reunion">
  			</div>
  			<div class="col-4">
  				<select name="" id="" class="form-control jsoninput" data-name="oficina" data-live-search="true" @change="jsonform" required="">
  					<option value="">SELECCIONAR OFICINA..</option>
  					<option v-for="item in oficinas" 
  					:key="item.id" 
  					:data-name="item.oficina" 
  					:data-id="item.id"
  					:selected="item.id == jsonselects.oficina.id">
  						{{item.oficina}}
  					</option>
  				</select>
  			</div>
  			<div class="col-4 text-center m-auto">
  				<VueDatePicker v-model="form.fecha_programada" format="YYYY-MM-DD"  clearable placeholder="Fecha programada: YYYY-MM-DD"></VueDatePicker>
  			</div>
  		</div>
  		<hr>
	</div>
</template>
<script>
	import { VueDatePicker } from '@mathieustan/vue-datepicker';
	import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';

	export default {
		components:{
			VueDatePicker
		},
		props:['form','type'],
		data: function() {
	    	return {
	    		loading:'',
	    		entidad:null,	
	    		motivos:null,
	    		empleados:null,
	    		sedes:null,
	    		oficinas:null,

	    	}
	    },
	  
	    mounted(){
			this.getSelects()

		},
		methods:{
		
			async getSelects() {
			  try {
			    const response = await axios.get(route('visitas.selects'));
			    this.entidad = response.data.entidad;
			    this.motivos = response.data.motivos;
			    this.empleados = response.data.empleados;
			    this.sedes = response.data.sedes;
			    this.oficinas = response.data.oficinas;

			  } catch (error) {
			    console.error(error);
			  }
			},
			jsonform(event){
				let nameinput = $(event.currentTarget).attr('data-name');
				this.form.itemsjson[nameinput] = {
					id:$(event.currentTarget).find(':selected').attr('data-id'),
					name:$(event.currentTarget).find(':selected').attr('data-name')
				}
			}	
		}, 
		computed:{
			jsonselects(){
				return this.form.itemsjson
			}
		},
		watch: {
		    entidad () {
		      	$(function () {
	              setTimeout(function(){  $('select').selectpicker('refresh'); }, 300);
	         	})
		    }
	  },
	

	}
</script>