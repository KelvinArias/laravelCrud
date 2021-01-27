<template>
    <div class="container">
        <h1 class="text-center">CRUD DE USUARIOS</h1>
        <hr>
        <div class="row">
            <div class="col-sm-12 justify-content-end d-flex" >
               <a href="#addEmployeeModal" @click="openModal('add')" class="btn btn-success d-flex" data-toggle="modal"><i class="material-icons mr-2">&#xE147;</i> <span>Agregar un usuario</span></a>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.address }}</td>
                <td>{{ user.phone }}</td>
                <td>
                    <a @click="openModal(user)" href="#editEmployeeModal" class="edit"><i class="material-icons" title="Edit">&#xE254;</i></a>
                    <a @click="eliminar(user.id)" href="#deleteEmployeeModal" class="delete"><i class="material-icons" title="Delete">&#xE872;</i></a>
                </td>
                </tr>
            </tbody>
            </table>
        </div>
        <!-- Modal add and edit user -->
        <div id="editUser" class="modal fade" v-bind:class="{show : modal}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">{{titleModal}}</h4>
                            <button @click="closeModal()" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                             <div class="form-group">
                                <label>Name</label>
                                <input v-model="user.name" type="text" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="user.email" type="email" class="form-control" required>
                            </div>
                            
                            <div v-if="!edit" class="form-group">
                                <label>Contraseña</label>
                                <input v-model="user.password" type="password" class="form-control" required>
                            </div>
                            
                            <div v-if="!edit" class="form-group">
                                <label>Confirmar contraseña</label>
                                <input v-model="user.confirmPasword" type="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Direccion</label>
                                <textarea v-model="user.address" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input v-model="user.phone" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar" @click="closeModal()">
                            <input @click="save()" type="submit" class="btn btn-success" value="Guardar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                titleModal: "",
                modal: false,
                id: "",
                users: [],
                edit: false,
                user: {
                    name: '',
                    email: '',
                    password: '',
                    confirmPasword: '',
                    address: '',
                    phone: '',
                },
            }
        },
        methods:{
            async listar (){
                const res = await axios.get('/users');
                this.users= res.data;
            },
            async eliminar (id){
                const res = await axios.delete('/users/'+id);
                this.listar();
            },
            async save (){
                if(this.edit){
                    const res = await axios.put('/users/'+ this.id, this.user)
                }else{
                    const res = await axios.post('/users', this.user)
                }
                this.closeModal();
                this.listar();
            },
            openModal (mode){
                this.modal = true;
                if(mode === "add"){
                    this.edit= false;
                    this.titleModal = "Agregar Usuario"
                    this.user = {
                        name: '',
                        email: '',
                        password: '',
                        confirmPasword: '',
                        address: '',
                        phone: '',
                    }
                }else{
                    this.edit= true;
                    this.user.name = mode.name;
                    this.user.email = mode.email;
                    this.user.address = mode.address;
                    this.user.phone = mode.phone;
                    this.user.password = mode.password;
                    this.user.confirmPasword = mode.confirmPasword;
                    this.id = mode.id;
                    this.titleModal = "Editar Usuario"
                }
            },
            closeModal (){
                this.modal = false;
            }
        },
        created() {
            this.listar();
        }
    }
</script>

<style scoped>
        body {
        color: #566787;
		background: #f5f5f5;
		font-family: 'Varela Round', sans-serif;
		font-size: 13px;
	}
    .show{
        display: list-item;
        opacity: 1;
        background: rgba(0, 0, 0, 0.459);
    }
	.table-wrapper {
        background: #fff;
        padding: 20px 25px;
        margin: 30px 0;
		border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
	.table-title {        
		padding-bottom: 15px;
		background: #435d7d;
		color: #fff;
		padding: 16px 30px;
		margin: -20px -25px 10px;
		border-radius: 3px 3px 0 0;
    }
    .table-title h2 {
		margin: 5px 0 0;
		font-size: 24px;
	}
	.table-title .btn-group {
		float: right;
	}
	.table-title .btn {
		color: #fff;
		float: right;
		font-size: 13px;
		border: none;
		min-width: 50px;
		border-radius: 2px;
		border: none;
		outline: none !important;
		margin-left: 10px;
	}
	.table-title .btn i {
		float: left;
		font-size: 21px;
		margin-right: 5px;
	}
	.table-title .btn span {
		float: left;
		margin-top: 2px;
	}
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
		padding: 12px 15px;
		vertical-align: middle;
    }
	table.table tr th:first-child {
		width: 60px;
	}
	table.table tr th:last-child {
		width: 100px;
	}
    table.table-striped tbody tr:nth-of-type(odd) {
    	background-color: #fcfcfc;
	}
	table.table-striped.table-hover tbody tr:hover {
		background: #f5f5f5;
	}
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }	
    table.table td:last-child i {
		opacity: 0.9;
		font-size: 22px;
        margin: 0 5px;
    }
	table.table td a {
		font-weight: bold;
		color:#3f9ae5;
		display: inline-block;
		text-decoration: none;
		outline: none !important;
	}

	table.table td a:hover {
		color: #000000;
	}
	
    table.table td i {
        font-size: 19px;
    }
	table.table .avatar {
		border-radius: 50%;
		vertical-align: middle;
		margin-right: 10px;
	}
    .pagination {
        float: right;
        margin: 0 0 5px;
    }
    .pagination li a {
        border: none;
        font-size: 13px;
        min-width: 30px;
        min-height: 30px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 2px !important;
        text-align: center;
        padding: 0 6px;
    }
    .pagination li a:hover {
        color: #666;
    }	
    .pagination li.active a, .pagination li.active a.page-link {
        background: #03A9F4;
    }
    .pagination li.active a:hover {        
        background: #0397d6;
    }
	.pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }    
	/* Custom checkbox */
	.custom-checkbox {
		position: relative;
	}
	.custom-checkbox input[type="checkbox"] {    
		opacity: 0;
		position: absolute;
		margin: 5px 0 0 3px;
		z-index: 9;
	}
	.custom-checkbox label:before{
		width: 18px;
		height: 18px;
	}
	.custom-checkbox label:before {
		content: '';
		margin-right: 10px;
		display: inline-block;
		vertical-align: text-top;
		background: white;
		border: 1px solid #bbb;
		border-radius: 2px;
		box-sizing: border-box;
		z-index: 2;
	}
	.custom-checkbox input[type="checkbox"]:checked + label:after {
		content: '';
		position: absolute;
		left: 6px;
		top: 3px;
		width: 6px;
		height: 11px;
		border: solid #000;
		border-width: 0 3px 3px 0;
		transform: inherit;
		z-index: 3;
		transform: rotateZ(45deg);
	}
	.custom-checkbox input[type="checkbox"]:checked + label:before {
		border-color: #03A9F4;
		background: #03A9F4;
	}
	.custom-checkbox input[type="checkbox"]:checked + label:after {
		border-color: #fff;
	}
	.custom-checkbox input[type="checkbox"]:disabled + label:before {
		color: #b8b8b8;
		cursor: auto;
		box-shadow: none;
		background: #ddd;
	}
    /* Modal styles */
	.modal .modal-dialog {
		max-width: 400px;
	}
	.modal .modal-header, .modal .modal-body, .modal .modal-footer {
		padding: 20px 30px;
	}
	.modal .modal-content {
		border-radius: 3px;
	}
	.modal .modal-footer {
		background: #ecf0f1;
		border-radius: 0 0 3px 3px;
	}
    .modal .modal-title {
        display: inline-block;
    }
	.modal .form-control {
		border-radius: 2px;
		box-shadow: none;
		border-color: #dddddd;
	}
	.modal textarea.form-control {
		resize: vertical;
	}
	.modal .btn {
		border-radius: 2px;
		min-width: 100px;
	}	
	.modal form label {
		font-weight: normal;
	}	
</style>