<template>
  <div class="login-container">
    <div class="login-card">
      <h2 class="login-title">Login</h2>
      <form @submit.prevent="verif" class="login-form">
        <div class="form-group">
          <label for="user" class="form-label">User:</label>
          <input
            type="text"
            id="user"
            class="form-input"
            v-model="user"
            placeholder="Enter your username"
            required
          />
        </div>
        <div class="form-group">
          <label for="password" class="form-label">Password:</label>
          <input
            type="password"
            id="password"
            class="form-input"
            v-model="password"
            placeholder="Enter your password"
            required
          />
        </div>
        <button type="submit" class="btn-login">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: '',
      password: '',
    };
  },
  methods: {
    verif() {
      const isValid = this.user === 'admin' && this.password === 'admin0';
      this.$emit('verif2', isValid);
    },
  },
};
</script>
<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  font-family: 'Arial', sans-serif;
  background: linear-gradient(135deg, #e0eafc, #cfdef3);
  margin:0; 
  height: 100vh; 
  display: flex; 
  justify-content: center; 
  align-items: center; 
}

.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 8rem;
  margin-left: 32rem;
  width: 100%; 
  max-width: 400px; 
  padding: 1rem; 
}


.login-card {
  background: #ffffff;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  width: 100%; 
  max-width: 400px; 
  text-align: center;
}



.login-title {
  font-size: 1.5rem;
  font-weight: bold;
  color: #333;
  margin-bottom: 1.5rem;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
}

.form-group {
  text-align: left;
}

.form-label {
  font-size: 0.9rem;
  font-weight: 500;
  color: #555;
  margin-bottom: 0.5rem;
  display: inline-block;
}

.form-input {
  width: 100%;
  padding: 0.8rem;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: border-color 0.3s;
}


.form-input:focus {
  border-color: #4ade80;
  outline: none;
}

.btn-login {
  background-color: #4ade80;
  color: #fff;
  border: none;
  padding: 0.8rem 1rem;
  border-radius: 4px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s;
}
@media (min-width: 768px) {
  .login-card {
    width: 400px; 
  }
  
}
@media (max-width: 419px) {
  .login-card {
    width: 400px; 
  }
  .login-container{
    margin-left: 6rem;
  }
  
}
.btn-login:hover {
  background-color: #22c55e;
}
</style>

