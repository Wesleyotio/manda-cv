<template>

    <div>
        <div class="container-fluid d-flex justify-content-center h-100" style="margin-top: 1%">
            <div class="card shadow p-0 mb-3  rounded" style="width: 150rem;">
                <div class="alert alert-danger" role="alert" v-if="!errors.success" style="align-self: center;">
                    {{ errors.data }}
                </div>
                <div class=" card-body d-flex justify-content-center form_container">
                    <form  method="post">
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
                            <input type="tel" class="form-control" id="inputPhone" :pattern="pattern" required
                                v-model="user.phone" @input=""
                                placeholder="(99)99999-9999">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-light">
                                    <i class="material-icons">business_center</i></span>
                            </div>
                            <input type="text" class="form-control" id="inputJob" required
                                v-model="user.job"
                                placeholder="Cargo desejado">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-light">
                                    <i class="material-icons">school</i></span>
                            </div>
                            <select id="inputEducationLevel" class="form-control" v-model="user.education_level" required>
                                <option selected>Escolaridade:</option>
                                <option v-for="level in educationLevels" :value="level.value" >{{ level.label }}</option>
                            </select>
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
                            <input type="file" name="file_cv" class="form-control" id="inputDoc"  @change="handleFileUpload" accept=".pdf,.doc,.docx" required
                                
                                placeholder="Currículo">
                        </div>

                        <div class="d-flex justify-content-center mt-3 ">
                            <button type="submit" class="btn btn-success "
                             @click="send" style="width: 100%;">Enviar</button>
                        </div>
                        <input type="hidden" name="userIP" v-model="user.ip_candidate" required>
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
                name: '',
                email: '',
                phone: '',
                pattern: "\\([1-9]{2}\\)[0-9]{5}-[0-9]{4}", 
                job: '',
                education_level: '',
                obs: '',
                ip_candidate: '0.0.0.0',
                doc_name_cv: null

            },
            errors: {
                success: true,
                data: ''
            },
            educationLevels: []
        }
    },
    methods: {
        
        send(e){
            e.preventDefault()

            const formData = new FormData();
            formData.append('name', this.user.name)
            formData.append('email', this.user.email)
            formData.append('phone', this.user.phone)
            formData.append('job', this.user.job)
            formData.append('education_level', this.user.education_level)
            formData.append('obs', this.user.description)
            formData.append('ip_candidate', this.user.ip_candidate) 
            formData.append('doc_name_cv', this.user.doc_name_cv);

            axios.post('api/send-cv', formData , {
                
                headers: {
                'Content-Type': 'multipart/form-data'
                },
            
                // name: this.user.name,
                // email: this.user.email,
                // phone: this.user.phone,
                // job: this.user.job,
                // education_level: this.user.education_level,
                // description: this.user.description,
                // ip_candidate: this.user.ip_candidate 
            })
            .then(response => {
               
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
        },
        getEducationLevel(){
            axios.get('api/list-education-level')
            .then(response =>{
                this.educationLevels = response.data.educationLevels
            })
            .catch(error => {
                console.log(error)
            });
        },

        formatPhoneInput(event) {
            let phoneNumber = event.target.value;
            phoneNumber = phoneNumber.replace(/\D/g, '');

            if (phoneNumber.length >= 10) {
                phoneNumber = phoneNumber.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3')
            }

            this.user.phone = phoneNumber
        },
        async getIp() {
            try {
                const response = await axios.get('https://api.ipify.org?format=json')
                this.user.ip_candidate = response.data.ip
            } catch (error) {
                console.error('Erro ao obter o IP:', error)
                this.user.ip_candidate = this.getRandomIp()
            }
        },

        getRandomIp() {
            const getRandomOctet = () => Math.floor(Math.random() * 256);
            
            const octet1 = getRandomOctet();
            const octet2 = getRandomOctet();
            const octet3 = getRandomOctet();
            const octet4 = getRandomOctet();

            return `${octet1}.${octet2}.${octet3}.${octet4}`;
        },
        handleFileUpload(event) {
            this.user.doc_name_cv = event.target.files[0];
        },

    },
    mounted() {
        this.getEducationLevel(),
        this.getIp()
    },
}
</script>
<style>

</style>