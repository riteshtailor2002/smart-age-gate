var age_app = new Vue({
	el: '#age-app',
	data: {
		isActive: false,
		child_1: false,
		child_2: false,
		child_3: false,
		child_4: false,
		year_1: '',
		year_2: '',
		year_3: '',
		year_4: '',
		remember_me: false,
		default_cookie_time: 1,
		message: '',
		rememberme_cookie_time: '',
		birth_heading: '',
		free_text: '',
		minimum_age: 18,
		background_image: '',
		background_color: '',
		background_image_color: 0,
	},
	mounted() {
		this.rememberme_cookie_time = smartagegate_object.smartagegate_cookie_time;
		this.birth_heading = smartagegate_object.smartagegate_birth_heading;
		this.free_text = smartagegate_object.smartagegate_free_text;
		this.minimum_age = smartagegate_object.smartagegate_minimum_age;
		this.background_image = smartagegate_object.smartagegate_background_image;
		this.background_color = smartagegate_object.smartagegate_background_color;
		this.background_image_color = smartagegate_object.smartagegate_background_color_or_image;		
		let checksmartagegate = this.accessCookie('age_gate_cookie');
		if (checksmartagegate == 1) {
			this.isActive = true
		}	
		this.cssVars();	
	},
	watch: {
	},	
	methods: {
		cssVars() {
			let styleStr;			
			if(this.background_image_color == 1){
				styleStr = {'background-image' : 'url('+this.background_image+')'};
			}
			else{
				styleStr = {'background-color' : this.background_color};
			}			
			return styleStr
		},
		checkYear_1(e) {
			var regex = /[1-9]/g
			if (regex.test(this.year_1) == false) {
				this.year_1 = ''
				return
			}
			if (this.year_1.length > 1) {
				this.year_1 = ''
				return
			}
			if (this.year_1 > 2) {
				this.year_1 = ''
				return
			}
			if (this.year_1 == 0) {
				this.year_1 = ''
				return
			}
			this.child_1 = false;
			this.$nextTick(() => {
				this.$refs.field_2.focus()
			});
		},
		checkYear_2(e) {
			if (this.year_2.length > 1) {
				this.year_2 = ''
				return
			}
			var regex = /[0-9]/g
			if (regex.test(this.year_2) == false) {
				this.year_2 = ''
				return
			}
			this.child_2 = false;
			this.$nextTick(() => {
				this.$refs.field_3.focus()
			});
		},
		checkYear_3(e) {
			if (this.year_3.length > 1) {
				this.year_3 = ''
				return
			}
			var regex = /[0-9]/g
			if (regex.test(this.year_3) == false) {
				this.year_3 = ''
				return
			}
			this.child_3 = false;
			this.$nextTick(() => {
				this.$refs.field_4.focus()
			});
		},
		checkYear_4(e) {
			if (this.year_4.length > 1) {
				this.year_4 = ''
				return
			}
			var regex = /[0-9]/g
			if (regex.test(this.year_4) == false) {
				this.year_4 = ''
				return
			}
			this.child_4 = false;
			this.validateYear();
		},
		validateYear() {
			if (this.year_1 != '' && this.year_2 != '' && this.year_3 != '' && this.year_4 != '') {
				this.child_4 = false;
				let input_year = `${this.year_1}${this.year_2}${this.year_3}${this.year_4}`
				let current_year = new Date().getFullYear();
				if (input_year.length > 0) {
					let calculated_age = current_year - parseInt(input_year);
					if (calculated_age >= this.minimum_age) {
						this.message = 'Congratulations'
						if (this.remember_me) {
							this.default_cookie_time = this.rememberme_cookie_time;
						}
						this.createCookie('age_gate_cookie', 1, this.default_cookie_time);
						this.isActive = true;
					}
					else {
						this.message = 'You are not of legal age to view this site'
					}
				}
			}
			else {
				this.message = 'Please enter correct values';
			}
		},
		blink1() {
			this.message = ''
			this.child_1 = true;
			this.validateYear();
		},
		blink2() {
			this.message = ''
			this.child_2 = true;
			this.validateYear();
		},
		blink3() {
			this.message = ''
			this.child_3 = true;
			this.validateYear();
		},
		blink4() {
			this.child_4 = true;
			this.validateYear();
		},
		createCookie(cookieName, cookieValue, daysToExpire) {
			var date = new Date();
			date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));
			document.cookie = cookieName + "=" + cookieValue + "; expires=" + date.toGMTString();
		},
		accessCookie(cookieName) {
			var name = cookieName + "=";
			var allCookieArray = document.cookie.split(';');
			for (var i = 0; i < allCookieArray.length; i++) {
				var temp = allCookieArray[i].trim();
				if (temp.indexOf(name) == 0)
					return temp.substring(name.length, temp.length);
			}
			return "";
		},
	}
});
