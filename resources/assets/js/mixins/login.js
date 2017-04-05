import { jwtToken } from '@/utils'
import { mapActions } from 'vuex'

export default {
    data() {
        return {
            redirect: this.$route.query.redirect
        }
    },
    methods: {
        login() {
            this.form.login().then(({ data }) => {
                let { token, user } = data;

                this.setUserAuth(user);
                jwtToken.setUserData(user);
                jwtToken.setToken(token);

                this.form.email = '';
                this.form.password = '';
                this.form.remember_me = false;

                if (this.redirect !== undefined) {
                    this.$router.push(this.redirect)
                }
            }).catch(error => console.log(error, 'error submit'))
        },
        ...mapActions(['setUserAuth'])
    }
}