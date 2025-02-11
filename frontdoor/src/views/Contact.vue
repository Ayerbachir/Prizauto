<template>
  <div class="table-container">
    <div class="header">
      <h1>
        <b style="color:#4ade80; font-size: 35px;">C</b>ontact
        <b style="color:#4ade80; font-size: 35px;">L</b>ist
      </h1>
    </div>

    <div class="main">
      <div class="lett-nav">
        <b>Send notification from here:</b>
      </div>

      <div class="form-container">
        <h2>Contact</h2>
        <form>
          <label for="name">User Name:</label>
          <input type="text" id="name" placeholder="Enter your name" />

          <label for="email">Email:</label>
          <input type="email" id="email" placeholder="Enter your email" />

          <label for="phone">Phone:</label>
          <input type="text" id="phone" placeholder="Enter your phone number" />

          <label for="message">Your message here:</label>
          <textarea id="message" placeholder="Type your message"></textarea>

          <div class="form-buttons">
            <button type="submit" class="btn">Send</button>
            <button type="button" class="btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
    };
  },
};
</script>

<style scoped>
.table-container {
  margin: 20px auto;
  
}

.main {
  margin-left: 2rem;
}

.header {
  margin-left: 7rem;
}

.lett-nav {
  margin: 2rem 0 1rem 3rem;
}

.form-container {
  margin: 2rem;
  width: 600px;
  padding-left:3rem;
  padding-bottom:3rem ;
  margin-left: 5%;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

form label {
  display: block;
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 8px;
  color: #333;
}

form input,
form textarea {
  width: 90%;
  padding: 15px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
}

form textarea {
  height: 100px;
  resize: none;
}

.form-buttons {
  display: flex;
  gap: 10px;
}
h2{
  padding: 3%;
  margin-left:-3% ;
}

.btn {
  padding: 10px 20px;
  border-radius: 5px;
  background-color: #4ade80;
  color: white;
  font-size: 14px;
  cursor: pointer;
  border: none;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #38a169;
}
</style>
