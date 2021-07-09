<template>
	<div>
		<div class="container-fluid">
		    <!-- Main row -->
		    <div class="row">
		    	<div class="col-12">
			     	<div class="card">
			     	   <div class="card-header bg bg-info">
			     	   		<b><i class="fas fa-eye"></i> Visitas</b>
			     	   </div>
		              <div class="card-body">
	              		
	              		<div class="row justify-content-center">
	              			<div class="col-2">
	              				<label for="" class="m-0">Desde:</label>
	              				<VueDatePicker v-model="fechaDesde" @onChange="tablesearch" ></VueDatePicker>

	              			</div>
	              			<div class="col-2 ">
	              				<label for="" class="m-0">Hasta:</label>

	              				<VueDatePicker v-model="fechaHasta" @onChange="tablesearch" ></VueDatePicker>
	              			</div>
	              		</div>
	              		<hr>
	              		<div class="row justify-content-center mt-2">
	              			<div class="col-4 text-center " style="margin-right: 96px;">
	              				<button class="btn btn-primary" @click="resetfilters('full')"><i class="fas fa-sync"></i> <b>RESET</b></button>
	              			</div>
	              		
	              		</div>
		                <div class="table-responsive">
		                    <data-table :columns="columns" class="table"  :urltable="url_table"></data-table>
		        		</div>

		              </div>
		            </div>

		     	</div>
		    </div>
		 	<modal 
			:showModal="showModal"
			:key="componentKey">
				<template v-slot:header>
				    Imagen de la visita <b>{{ namemodal }}</b>
				</template>
		    	<img :src="`${srcmodal}`" alt="" class="img-fluid w-100">
		    </modal>

		    <!-- /.row (main row) -->
		</div>
	</div>
</template>
<script>
	import DataTable from '@/components/datatables/DataTableVisitas.vue';
	import { VueDatePicker } from '@mathieustan/vue-datepicker';
	import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';
	import Modal from '@/components/Modal.vue';

	import {mapGetters} from 'vuex';
	export default {
		props:['typevisita'],
		components: {
	      DataTable,VueDatePicker,Modal
	    },
	    data: function() {
	    	return {
	    		url_table:route('visitas.indexp'),
	    		fechadesdec:null,
	    		showModal:false,
	    		componentKey:0,
	    		srcmodal:null,
	    		namemodal:null,
	    		columns:[
			        {
			        	data:'fecha',
			        },
			        {
			        	data:'fecha_programada',
			        	title:'Fecha.P'
			        },
			        {
			        	data:'nombre',
			        },
			        {
			        	data:'dni',
			        	title:'Identificacion',
			        	
			        },
			        {
			        	data:'entidad',
			        	title:'Entidad'
			        },
			        {
			        	data:'motivo',
			        	title:'Motivo'
			        },
			        {
			        	data:'empleado',
			        	title:'Empleado Publico'
			        },
			        {
			        	data:'sede',
			        	title:'Sede'
			        },
			        {
			        	data:'oficina',
			        	title:'Oficina'
			        },
			        {
			        	data:'hora_entrada',
	
			        },
			        {
			        	data:'hora_salida',
			    
			        },
			      

			    ],
	    	}
	    },
	    created(){
	    	this.$store.dispatch('fechavisitas/addTypeVisita',1)
	    },
	    computed:{
	    	fechaDesde: {
			    // getter
			    get: function () {
			      return this.$store.getters['fechavisitas/desde']
			    },
			    // setter
			    set: function (newValue) {
			      this.$store.commit('fechavisitas/setDesde',newValue)
			      this.fechadesdec = newValue;
			    }
			},
			fechaHasta: {
			    // getter
			    get: function () {
			      return this.$store.getters['fechavisitas/hasta']
			    },
			    // setter
			    set: function (newValue) {
			      this.$store.commit('fechavisitas/setHasta',newValue)
			    }
			},
	    },
	    methods:{	 		
	    	resetfilters(type){
	    		this.$store.commit('fechavisitas/setHasta',null)
	    		this.$store.commit('fechavisitas/setDesde',null)
	    		if(type == 'full'){
	    	    	$('#table_id').DataTable().draw();
	    	    }
	    	},
	    	tablesearch(event){
	    	   $('#table_id').DataTable().draw();
	    	}
	    }
	}
</script>