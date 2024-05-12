<template>

    <div>
        <div class="container-fluid d-flex justify-content-center h-100" style="margin-top: 1%">
            <div class="card shadow p-0 mb-3  rounded" style="width: 150rem;">
                <div class="alert alert-danger" role="alert" v-if="!errors.success" style="align-self: center;">
                    {{ errors.data }}
                </div>
                <div class=" card-body d-flex justify-content-center form_container">
                    <form  method="post" >
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-light">
                                    <i class="material-icons">person</i></span>
                            </div>
                            <input type="text" class="form-control" id="inputName" aria-describedby="emailHelp" required
                                v-model="user.name"
                                placeholder="Nome">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-light">
                                    <i class="material-icons">email</i></span>
                            </div>
                            <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" required
                                v-model="user.email"
                                placeholder="E-mail">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-light">
                                    <i class="material-icons">phone</i></span>
                            </div>
                            <input type="tel" class="form-control" id="inputPhone" pattern="([1-9]{2})[0-9]{5}-[0-9]{4}" required
                                v-model="user.phone"
                                placeholder="(99)99999-9999">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-light">
                                    <i class="material-icons">school</i></span>
                            </div>
                            <input type="text" class="form-control" id="inputText" required
                                v-model="user.education"
                                placeholder="Escolaridade">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-light">
                                    <i class="material-icons">description</i></span>
                            </div>
                            <textarea  type="text" class="form-control" id="inputText"  rows="5" cols="55"
                                v-model="user.description"
                                placeholder="Observações"/>
                        </div>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-light">
                                    <i class="material-icons">attach_file</i></span>
                            </div>
                            <input type="file" name="file_cv" class="form-control" id="inputPassword" accept=".pdf,.doc,.docx" required
                                
                                placeholder="Currículo">
                        </div>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-light">
                                    <i class="material-icons">vpn_key</i></span>
                            </div>
                            <input type="password" name="password" class="form-control" id="inputPassword"
                                v-model="user.password"
                                placeholder="senha">
                        </div>

                        <div class="d-flex justify-content-center mt-3 ">
                            <button type="submit" class="btn btn-success "
                            @click="login"
                            style="width: 100%;">Entrar </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            user: {
                email: '',
                password: '',
            },
            errors: {
                success: true,
                data: ''
            }
        }
    },
    methods: {
        login(e){
            e.preventDefault()
            axios.post('api/login', {
                email: this.user.email,
                password: this.user.password
            })
            .then(response => {
                const data = new Date();
                localStorage.setItem('toDay', data.getTime())
                localStorage.setItem('isLoggedIn', true)
                localStorage.setItem('user', response.data.user)
                localStorage.setItem('token', response.data.token)
                if (response.data.success) {
                    this.emitter.emit('isLoggedIn', true)
                    this.$router.push("/")
                }
            })
            .catch(error => {
                console.log(error)
                alert("Email ou senha errados!")
                this.user.email = ''
                this.user.password = ''

            });
        }
    },
}
</script>
<style>

</style>