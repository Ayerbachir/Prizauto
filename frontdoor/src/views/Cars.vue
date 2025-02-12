<template>

  <div class="table-container">
    <div class="header">
      <h1><b style="color:#4ade80; font-size: 35px;">C</b>ars <b style="color:#4ade80; font-size: 35px;">L</b>ist</h1>
    </div>
    <div v-if="showNotification" class="notification">
  {{ notificationMessage }}
</div>
    <div class="main">
      <div class="lett-nav">
        Add car : 
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
          <th>Model</th>
          <th>Matricul</th>
          <th>Price</th>
          <th>State</th>
          <th>Modify</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="car in cars" :key="car.id">
          <td>{{ car.name }}</td>
          <td>{{ car.model }}</td>
          <td>{{ car.matricul }}</td>
          <td>{{ car.price }}</td>
          <td>{{ car.state }}</td>
          <td>
            <button class="btn tn" @click="hand(car)">Edit</button>
            <button class="btn" @click="delet(car)">Delete</button>
          </td> 
        </tr>
      </tbody>
    </table>

    <div v-if="isModalVisible1" class="modal-overlay" @click="closeModal1">
      <div class="modal-content" @click.stop>
        <h2>Add Car</h2>
        <form @submit.prevent="addCar">
          <label for="name">Car Name:</label>
          <input type="text" id="name" v-model="newCar.name" required>

          <label for="model">Model:</label>
          <input type="text" id="model" v-model="newCar.model" required>

          <label for="matricul">Matricul:</label>
          <input type="text" id="matricul" v-model="newCar.matricul" required>

          <label for="price">Price:</label>
          <input type="number" id="price" v-model="newCar.price" required>

          
          <button type="submit" class="btntn">Add Car</button>
          <button type="button" class="btntn" @click="closeModal1">Cancel</button>
        </form>
      </div>
    </div>


    <div v-if="isModalVisible2" class="modal-overlay" @click="closeModal1">
      <div class="modal-content" @click.stop>
        <h2>search Car</h2>
        <form @submit.prevent="search(newCar)">
          <label for="name">Car Name:</label>
          <input type="text" id="name" v-model="newCar.name" >

          <label for="model">Model:</label>
          <input type="text" id="model" v-model="newCar.model" >

          <label for="price">Price:</label>
          <input type="number" id="price" v-model="newCar.price">

          <label for="state">State:</label>
          <input type="text" id="state" v-model="newCar.state" >

          <label for="nci">Nci:</label>
          <input type="number" id="nci" v-model="newCar.nci" >

          <button type="submit" class="btntn">search</button>
          <button type="button" class="btntn" @click="closeModal1">Cancel</button>
        </form>
      </div>
    </div>

    <div v-if="isModalVisible3" class="modal-overlay" @click="closeModal1">
      <div class="modal-content" @click.stop>
        <h2>Edit Car</h2>
        <form @submit.prevent="edit()">
          <label for="name">Car Name:</label>
          <input type="text" id="name"  v-model="newCar.name"  :disabled=true >

          <label for="model">Model:</label>
          <input type="text" id="model" :disabled=true  v-model="newCar.model">

          <label for="price">Price:</label>
          <input type="number" id="price" v-model="newCar.price" >

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
      cars: [],
      isModalVisible1: false,
      isModalVisible2:false,
      isModalVisible3:false,
      showNotification:false,
      newCar: {
        id:"",
        name: '',
        model: '',
        matricul:'',
        price: '',
        state: '',
      }
    }
  },
  mounted() {
    this.fetchCars();
    
  },
  methods: {

    delet(car) {
      if (confirm(`Are you sure you want to delete ${car.name}?`)) {
        axios.delete(`http://127.0.0.1:8000/api/cars/${car.id}`)
        .then(() => {
          this.cars = this.cars.filter(c => c.id !== car.id);
        })
        .catch(error => {
          console.error("Error deleting car:", error);
          this.notificationMessage = "Error deleting  Car. Please try again.";
          this.showNotification = true;
        });
    }
}
,
    fetchCars() {
      axios.get('http://127.0.0.1:8000/api/cars')
        .then(response => {
          this.cars = response.data;
          this.notificationMessage='Refreshing!'
          this.showNotification = true;
          setTimeout(() => {
          this.showNotification = false;
        }, 1500);
        })
        .catch(error => {
          console.error("There was an error fetching the car data:", error);
          
        });
    },
    openModal1() {
      this.isModalVisible1 = true;
    },
    openModal2() {
      this.isModalVisible2 = true;
    },
    openModal3(car) {
      this.newCar.id=car.id;
      this.newCar.name = car.name;
      this.newCar.model = car.model;
      this.newCar.price = car.price;
      this.newCar.matricul=car.matricul;
      this.newCar.state = car.state;
      this.isModalVisible3 = true;
    },
    closeModal1() {
      this.isModalVisible1 = false;
      this.isModalVisible2 = false;
      this.isModalVisible3 = false;
      this.newCar = {
        id:"",
        name: '',
        model: '',
        matricul:'',
        price: '',
        state: '',
      };
    },
   
    addCar() {
      this.newCar.state='Available';
  axios.post('http://127.0.0.1:8000/api/cars', this.newCar)
    .then(() => {
          this.fetchCars();
          this.notificationMessage='Adding Car successfully!'
          this.showNotification = true;
          setTimeout(() => {
          this.showNotification = false;
        }, 1500);
       this.closeModal1();})
    .catch(error => {
      console.error("Error adding car:", error);
      this.notificationMessage = "Error adding  Car. Please try again.";
      this.showNotification = true;
    });
    console.log(this.newCar);
}
,
    search() {
      axios.get('http://127.0.0.1:8000/api/cars', { params: this.newCar })
      .then(response => {
        this.cars = response.data; 
        this.closeModal1();
      }).catch(error => {
        console.error("Error during search:", error);
      });
    },
    
    edit() {
    axios.patch(`http://127.0.0.1:8000/api/cars/${this.newCar.id}/edit`, this.newCar)
      .then(() => {
        this.fetchCars();
        this.notificationMessage='Editing  Car successfully!'
          this.showNotification = true;
          setTimeout(() => {
          this.showNotification = false;
        }, 1500);
        this.closeModal1();
      })
      .catch((error) => {
      console.error("Error during patch request:", error);
      this.notificationMessage = "Error Edite  Car. Please try again.";
      this.showNotification = true;
      });
},


  hand(car){
      this.openModal3(car);
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