<template>
	<div>
		<section-content>
		  	<form-modal 
			:tipe="tipeform"
			:urlform="urlform"
			:tipemessage="tipemessage" 
			:form="form"
			:key="componentKey"
			:showModal="showModal"
			/>
		    <!-- Main row -->
		    <div class="row">
		    	<div class="col-12">
			     	<div class="card">
			     	   <div class="card-header bg bg-info">
			     	   		<b><i class="fas fa-user"></i> Usuarios </b>
			     	   </div>
		              <div class="card-body">
	              		<button type="button" class="btn btn-primary mb-1" @click.prevent="createform">
		              	  <i class="fas fa-plus-square"></i>
						  ADD
						</button>
		                <div class="table-responsive">
		                    <data-table :columns="columns" class="table"  :urltable="url_table"></data-table>
		        		</div>

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
	import DataTable from '@/components/datatables/DataTable.vue';
	import FormModal from '@/components/users/form.vue';

	export default {
		components: {
	      SectionContent,HeaderTitle,DataTable,FormModal
	    },
	    data: function() {
	    	return {
	    		url_table:route('users.index'),
	    		urlform:null,
	    		tipeform:null,
	    		tipemessage:null,
	    		showModal:false,
	    		componentKey:0,
	    		form:{
	    			name:'',
	    			email:'',
	    			password:'',
	    			rol:'empty'
	    		},
	    		columns:[
			        {
			        	data:'id',
			        },
			        {
			        	data:'name',
			        },
			        {
			        	data:'email',
			        },
			        {
			        	data:'created_at',
			        },
			        {
			        	data:'action',
			        	orderable: false,
			          	searchable: false,
			          	createdCell:this.createdCell,
			        }
			    ],
	    	}
	    },
	    
	    methods:{
	   
		 	createform(){
             	this.form = {
             		oficina:'',
	    			name:'',
	    			email:'',
	    			password:'',
	    			rol:''
             	}
             	this.urlform = route('users.save')
             	this.tipeform = 'create'
             	this.tipemessage = `Crear Usuario `
             	this.componentKey += 1
             	this.showModal = true
	       	},
		   	createdCell(cell, cellData, rowData) {


		          	$(cell).empty()
		            let actions = Vue.extend(require('@/components/datatables/actions.vue').default);
		            let instance = new actions({
		                propsData: {
		                	id:rowData.id,
		                	url_delete:route('users.delete'),
		                },
		            });
		            instance.$mount()
		            let me = this
		        	instance.$on('edit_emit', function(event) {

		        		//me.$router.push(`visitas/edit/${rowData.id}`) // -> /user
		        		me.form = rowData
		        		me.form.rol = rowData.roles[0].name
		             	me.urlform = route('users.update')
		             	me.tipeform = 'update'
		             	me.tipemessage = `Actualizar oficina ${rowData.id} `
		             	me.componentKey += 1
		             	me.showModal=true
		        	})
		        	


		            $(cell).empty().append(instance.$el)
	        	
	            
		   	},
	    }
	}
</script>