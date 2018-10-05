<template>
    <div class="login row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Register Now !</div>
                <div class="card-body">
                    <form @submit.prevent="registerUser">
                        <div class="form-group row">
                            <label for="name">Name:</label>
                            <input type="text" v-model="form.name" class="form-control" placeholder="Full Name">
                        </div>
                        <div class="form-group row">
                            <label for="email">Email:</label>
                            <input type="email" v-model="form.email" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group row">
                            <label for="password">Password:</label>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group row">
                            <input type="submit" value="Register">
                        </div>
                        <div class="form-group row" v-if="authError">
                            <p class="error">
                                {{ authError }}
                            </p>
                        </div>
                    </form>
                    <div class="errors" v-if="error">
                        <ul>
                            <li v-for="(fieldsError, fieldName) in error" :key="fieldName">
                                <strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { register } from '../../helpers/auth';
    import validate from 'validate.js';

    export default {
        name: "regoster",
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: ''
                },
                error: null
            };
        },
        methods: {
            registerUser() {
                this.error = null
                const constraints = this.getConstraints();

                const errors = validate(this.$data.form, constraints);
                if (errors) {
                    this.error = errors;
                    return;
                }
                register(this.$data.form)
                    .then((res) => {
                        this.$router.push({path: '/'});
                    })
                    .catch((error) => {
                        console.log(error.response)
                        this.$store.commit("loginFailed", {error});
                    });
            },
            getConstraints() {
                return {
                    name: {
                        presence: true,
                        length: {
                            minimum: 3,
                            message: 'Must be at least 3 characters long'
                        }
                    },
                    email: {
                        presence: true,
                        email: true
                    },
                    password: {
                        presence: true,
                        length: {
                            minimum: 8,
                            message: 'Must be at least 8 character long'
                        }
                    }
                }
            }
        },
        computed: {
            authError() {
                return this.$store.getters.authError;
            }
        }
    }
</script>

<style scoped>
.error {
    text-align: center;
    color: red;
}
</style>

