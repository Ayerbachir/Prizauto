<template>

  <div class="table-container" >
    <div class="header">
      <h1><b style="color:#4ade80; font-size: 35px;">C</b>lients <b style="color:#4ade80; font-size: 35px;">L</b>ist</h1>
    </div>
    <div v-if="showNotification" class="notification">
      {{ notificationMessage }}
    </div>
    <div class="main">
      <div class="lett-nav">
        Add User : 
        <button class="btn" @click="openModal1">Add</button>
        <div class="lett-nav">
          search : 
          <button class="btn" @click="openModal2">search</button>
        </div>
        <div class="lett-nav">
          refresh : 
          <button class="btn" @click="fetchCars">refresh</button>
        </div>
      </div>
    
    <table class="car-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Nci</th>
          <th>Modify</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in usser" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.phone }}</td>
          <td>{{ user.nci }}</td>
          <td>
            <button class="btn tn" @click="hand(user)">Edit</button>
            <button class="btn" @click="delet(user)">Delete</button>
            <button class="btn" >Contact</button>
          </td> 
        </tr>
      </tbody>
    </table>

    <div v-if="isModalVisible1" class="modal-overlay" @click="closeModal1">
      <div class="modal-content" @click.stop>
        <h2>Add User</h2>
        <form @submit.prevent="addCar">
          <label for="name">User Name:</label>
          <input type="text" id="name" v-model="newUser.name" required>

          <label for="email">Email:</label>
          <input type="text" id="email" v-model="newUser.email" required>

          <label for="password">Password:</label>
          <input type="text" id="password" v-model="newUser.password" required>

          <label for="phone">Phone:</label>
          <input type="number" id="phone" v-model="newUser.phone" required>

          <label for="nci">Nci:</label>
          <input type="number" id="nci" v-model="newUser.nci" >

          <button type="submit" class="btntn">Add</button>
          <button type="button" class="btntn" @click="closeModal1">Cancel</button>
        </form>
      </div>
    </div>


    <div v-if="isModalVisible2" class="modal-overlay" @click="closeModal1">
      <div class="modal-content" @click.stop>
        <h2>search User</h2>
        <form @submit.prevent="search(newUser)">
          <label for="name">User Name:</label>
          <input type="text" id="name" v-model="newUser.name" >

          <label for="model">Email:</label>
          <input type="text" id="model" v-model="newUser.email" >


          <label for="state">Phone:</label>
          <input type="text" id="state" v-model="newUser.phone" >

          <label for="nci">Nci:</label>
          <input type="number" id="nci" v-model="newUser.nci" >

          <button type="submit" class="btntn">search</button>
          <button type="button" class="btntn" @click="closeModal1">Cancel</button>
        </form>
      </div>
    </div>

    <div v-if="isModalVisible3" class="modal-overlay" @click="closeModal1">
      <div class="modal-content" @click.stop>
        <h2>Edit User</h2>
        <form @submit.prevent="edit()">
          <label for="name">User Name:</label>
          <input type="text" id="name"  v-model="newUser.name"  :disabled=true >

          <label for="model">Email:</label>
          <input type="text" id="model" :disabled=true  v-model="newUser.email">


          <label for="state">Phone:</label>
          <input type="text" id="state" v-model="newUser.phone" required>

          <label for="nci">Nci:</label>
          <input type="number" id="nci" v-model="newUser.nci" :disabled=true >

          <button type="submit" class="btntn">Edit</button>
          <button type="button" class="btntn" @click="closeModal1">Cancel</button>
        </form>
      </div>
    </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      showNotification: false,
      notificationMessage: "",
      usser: [],
      isModalVisible1: false,
      isModalVisible2:false,
      isModalVisible3:false,

      newUser: {
        id:"",
        name: '',
        email: '',
        password: '',
        phone: '',
        nci: '',
      }
    }
  },
  mounted() {
    this.fetchCars();
  },
  methods: {
    delet(user) {
      if (confirm(`Are you sure you want to delete ${user.name}?`)) {
        axios.delete(`http://127.0.0.1:8000/api/users/${user.id}`)
        .then(() => {
          this.notificationMessage='user was deleted!'
          this.showNotification = true;
          setTimeout(() => {
          this.showNotification = false;
        }, 1500);
          this.usser = this.usser.filter(c => c.id !== user.id);
        })
        .catch(error => {
          console.error("Error deleting user:", error);
        });
    }
},

fetchCars() {
      axios.get('http://127.0.0.1:8000/api/users')
        .then(response => {
          this.usser = response.data;
          this.notificationMessage='refreshing!'
          this.showNotification = true;
          setTimeout(() => {
          this.showNotification = false;
        },1000);
        })
        .catch(error => {
          console.error("Error fetching data:", error);
          this.notificationMessage = "Error fetching data . Please try again and check server.";
          this.showNotification = true;
        });
    },
    openModal1() {
      this.isModalVisible1 = true;
    },
    openModal2() {
      this.isModalVisible2 = true;
    },
    openModal3(usser) {
      this.newUser.id=usser.id;
      this.newUser.name = usser.name;
      this.newUser.email = usser.email;
      this.newUser.password = usser.password;
      this.newUser.phone = usser.phone;
      this.newUser.nci = usser.nci;
      this.newUser.carname= usser.carname
      this.isModalVisible3 = true;
    },
    closeModal1() {
      this.isModalVisible1 = false;
      this.isModalVisible2 = false;
      this.isModalVisible3 = false;
      this.newUser = {
        id:"",
        name: '',
        email: '',
        password: '',
        phone: '',
        nci:"",
      };
    },
   
    addCar() {
    axios.post('http://127.0.0.1:8000/api/users', this.newUser)
    .then(() => {
      this.notificationMessage = `Adding user successfully!`;
      this.showNotification = true;
      setTimeout(() => {
          this.showNotification = false;
        }, 1000);
      this.fetchCars(); 
      this.closeModal1();
    })
    .catch(error => {
      console.error("Error adding car:", error);
      this.notificationMessage = "Error adding  User. Please try again.";
        this.showNotification = true;
    });
    
},
    search() {
      axios.get('http://127.0.0.1:8000/api/users', { params: this.newUser })
      .then(response => {
        this.usser = response.data; 
        this.closeModal1();
      }).catch(error => {
        console.error("Error during search:", error);
      });
    },
    
    edit() {
    axios.patch(`http://127.0.0.1:8000/api/users/${this.newUser.id}/edit`, this.newUser)
      .then(() => {
        this.fetchCars();
        this.notificationMessage = `updating  successfully!`;
        this.showNotification = true;
        setTimeout(() => {
          this.showNotification = false;
        }, 1500);
        this.closeModal1();
      })
      .catch((error) => {
      console.error("Error during patch request:", error);
      });
},


  hand(user){
      this.openModal3(user);
      if(!this.isModalVisible3){
        this.edit();
      }
    },

  }
}
</script>


<style scoped>
table{
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}
.table-container {
  margin: 20px auto;
  padding: 1px;
}
.main{
  margin-left: 2rem;
}
.btntn{
  padding: 6px 12px;
  margin-left: 5px;
  border-radius: 5px;
  background-color: #4ade80;
  color: white;
  font-size: 14px;
  cursor: pointer;
}
.btn {
  padding: 6px 12px;
  margin-left: 5px;
  border-radius: 5px;
  background-color: #4ade80;
  color: white;
  font-size: 14px;
  cursor: pointer;
}

.lett-nav {
  margin: 3rem 0 1rem 3rem;
  display:inline-block;
}

.btn:hover {
  background-color: #38a169;
}

.car-table {
  width: 100%;
  padding: 1rem;
  border-collapse: collapse;
  table-layout: fixed;
}

.car-table th,
.car-table td {
  padding: 8px;
  padding-right: 60px;
  text-align: left;
  border: 1px solid #ddd;
}

.car-table th {
  background-color: #f2f2f2;
  font-weight: bold;
}

.car-table tr:nth-child(even) {
  background-color: #f9f9f9;

}

.car-table tr:hover {
  background-color: #e2e2e2;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
}

.modal-content input {
  width: 100%;
  padding: 8px;
  margin: 10px 0;
  border: 1px solid #ddd;
  border-radius: 5px;
}
.header{
  margin-left: 7rem;
}

.modal-content button {
  margin-top: 10px;
  width: 100%;
}

@media (max-width: 1024px) {
  .car-table th,
  .car-table td {
    font-size: 14px;
    padding: 10px;
  }

  .btn {
    padding: 5px 10px;
    font-size: 12px;
  }
}

@media (max-width: 768px) {
  .car-table th,
  .car-table td {
    font-size: 12px;
    padding: 6px;
  }

  .btn {
    padding: 4px 8px;
    font-size: 10px;
  }

  .table-container {
    padding: 10px;
  }
}

@media (max-width: 775px) {
  .car-table th,
  .car-table td {
    font-size: 10px;
    padding: 4px;
    color: red;
  }
  .lett-nav{
    margin: 0;
    display:inline-block
  }
  .btn {
    padding: 3px 6px;
    font-size: 8px;
  }

  .car-table th {
    font-size: 10px;
  }

  .table-container {
    padding: 5px;
    margin-left: 20%;
  }
}
.notification {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 10px 20px;
  background-color: #4ade80; /* Success green */
  color: white;
  border-radius: 5px;
  font-size: 16px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  z-index: 1000;
  animation: fadeInOut 1.5s ease-in-out;
}

@keyframes fadeInOut {
  0% {
    opacity: 0;
    transform: translateY(-20px);
  }
  10% {
    opacity: 1;
    transform: translateY(0);
  }
  90% {
    opacity: 1;
    transform: translateY(0);
  }
  100% {
    opacity: 0;
    transform: translateY(-20px);
  }
}
</style>