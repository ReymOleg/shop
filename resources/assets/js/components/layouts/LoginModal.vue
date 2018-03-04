<template>
	<div class="login-modal">
		<div class="login-choose row">
			<div class="col-xs-6 center login-tab" :class="tabs.login" @click="toggleTab('login')">Вход</div>
			<div class="col-xs-6 center register-tab" :class="tabs.register" @click="toggleTab('register')">Регистрация</div>
		</div>
		<div class="clear"></div>
		<div class="login-block padding" :class="tabs.login">
			<div class="login-form">
				<h2 class="center">Вход в аккаунт</h2>
				<div class="input-field">
		        	<input type="text" id="login-email" placeholder=" " v-model="loginFields.email">
					<label for="login-email">Email</label>
				</div>
				<div class="input-field">
		        	<input type="password" id="login-pass" placeholder=" " v-model="loginFields.password">
					<label for="login-pass">Пароль</label>
		        </div>
		        <button @click="loginUser()" @keyup.enter="loginUser()" class="button primary block center">Войти</button>
			</div>
		</div>
		<div class="register-block padding" :class="tabs.register">
			<h2 class="center">Регистрация</h2>
			<div class="input-field">
	        	<input type="text" id="register-name" placeholder=" " v-model="registerFields.name">
				<label for="register-name">Имя</label>
			</div>
			<div class="input-field">
	        	<input type="text" id="register-email" placeholder=" " v-model="registerFields.email">
				<label for="register-email">Email</label>
			</div>
			<div class="input-field">
	        	<input type="password" id="register-pass" placeholder=" " v-model="registerFields.password">
				<label for="register-pass">Пароль</label>
	        </div>
	        <div class="input-field">
	        	<input type="text" id="register-coupon" placeholder=" " v-model="registerFields.coupon">
				<label for="register-coupon">Купон</label>
			</div>
	        <button @click="createUser()" @keyup.enter="createUser()" class="button primary block center">Зарегистрироваться</button>
		</div>
	</div>
</template>

<script type="text/javascript">
	import { mapGetters } from 'vuex'
	import { mapActions } from 'vuex'

	export default {
		data() {
			return {
				loginFields: {
					email: '',
					password: '',
				},
				registerFields: {
					email: '',
					password: '',
					name: '',
					coupon: '',
				},
				tabs: {
					login: {
						'active': true
					},
					register: {
						'active': false
					}
				}
			}
		},
		methods: {
			...mapActions({
				login: 'user/login',
				create: 'user/create'
			}),
			toggleTab(tab) {
				for(let i in this.tabs) {
					i == tab ? this.tabs[i]['active'] = true : this.tabs[i]['active'] = false
				}
			},
			loginUser() {
				let _self = this;

				this.$snotify.async(
					'Пожалуйста ожидайте',
					'Авторизация',
					() => new Promise((resolve, reject) => {
			      _self.login(_self.loginFields)
							.then((response) => {
								resolve({
					        title: 'Успешно!',
					        body: 'Здравствуйте, ' + response.data.user.name + '!',
					        config: {
					          closeOnClick: true,
					          timeout: 2000
					        }
					      })
					    })
					    .catch((e) => {
					    	reject({
					        title: 'Ошибка!',
					        body: 'Проверьте правильность полей',
					        config: {
					          closeOnClick: true,
					          timeout: 3000
					        }
					      })
					    })
			  	})
		  	)

			},
			createUser() {
				let _self = this;

				this.$snotify.async(
					'Пожалуйста ожидайте',
					'Авторизация',
					() => new Promise((resolve, reject) => {
			      _self.create(_self.registerFields)
							.then((response) => {
								resolve({
					        title: 'Успешно!',
					        body: 'Здравствуйте, ' + response.data.user.name + '!',
					        config: {
					          closeOnClick: true,
					          timeout: 2000
					        }
					      })
					    })
					    .catch((e) => {
					    	reject({
					        title: 'Ошибка!',
					        body: 'Проверьте правильность полей',
					        config: {
					          closeOnClick: true,
					          timeout: 3000
					        }
					      })
					    })
			  	})
		  	)
		  	
				
			}
		},
		computed: {
			...mapGetters({
				userData: 'user/userData'
			})
		},
		watch: {
			'userData': {
				handler: function() {
					console.log(this.userData)
				}
			}
		}
	}
</script>