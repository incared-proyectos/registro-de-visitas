<template>
    <div>
        <!-- Modal -->
        <button  @click="marcar" class="btn btn-primary btn-sm"  title="Editar"  >
            <slot>MARCAR</slot>
        </button>
    </div>
</template>

<script>
    export default{
        props: ['id','url_marcar'],
        methods: {
          marcar(event) {
            //this.$parent.$router.push(this.url_edit)

            let me = this;
            swal.fire({
              title:'Estas seguro?',
              text: "Marcara la salida",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, Marcar!'
            }).then((result) => {
              if (result.isConfirmed) {           
                axios.post(this.url_marcar, {
                  id_data: this.id,
                }).then((response) => {
                  $('#table_id').DataTable().ajax.reload();

                }).catch((error) => {
                  console.error(error);
                });
              }
            })
          },

        },
    }
</script>