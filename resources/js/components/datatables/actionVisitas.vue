<template>
    <div>
        <!-- Modal -->
        <button  @click="edit" class="btn btn-primary btn-sm "  title="Editar"  >
            <slot><i class="fas fa-edit"></i></slot>
        </button>
        <button  @click="delete_action" class="btn btn-danger btn-sm "  title="Eliminar"  >
            <slot><i class="fas fa-trash"></i></slot>
        </button>
        <button  @click="view" class="btn btn-info btn-sm m-1"  title="Visualizar"  >
            <slot><i class="fas fa-eye"></i></slot>
        </button>
    </div>
</template>

<script>
    export default{
        props: ['id','url_eliminar'],
        methods: {
          edit(event) {
            //this.$parent.$router.push(this.url_edit)

          },
          delete_action(event) {
            //this.$parent.$router.push(this.url_edit)

            let me = this;
            swal.fire({
              title:'Estas seguro?',
              text: "Vas a eliminar esta visita",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
              if (result.isConfirmed) {           
                axios.post(this.url_eliminar, {
                  id_data: this.id,
                }).then((response) => {
                  $(`#codenv${me.id}`).remove();

                  $('#table_id').DataTable().ajax.reload();

                }).catch((error) => {
                  console.error(error);
                });
              }
            })
          },
          view(event){

          }

        },
    }
</script>