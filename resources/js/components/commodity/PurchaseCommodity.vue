<template>
  <div class="col-10 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Purchase Commodity For User</h4>
        <p class="card-description"> Purchase Commodityy</p>

        <form
          method="POST"
          action
          @submit="submitCommodity($event)"
          enctype="multipart/form-data"
        >


          <div class="form-group">
            <label for="address">Select User :</label>
            <select
              name="user"
              v-model="field.user"
              id
              class="form-control"
            >
              <!-- <option value="1" v-for="">Available</option> -->
               <option value="1" >Available</option>
            
            </select>
          </div>
          <div class="form-group">
            <label for="name">User Balance :</label>
            <input
              type="text"
              v-model="field.user_balance"
              class="form-control"
              id="product_name"
              name="commodity_name"
              placeholder="Enter Commodity Name "
            />

            <span
              class="invalid-feedback alert-danger"
              v-if="'commodity_name' in errors"
              style="display: block"
              role="alert"
            >
              <strong>{{ this.errors.commodity_name[0] }}</strong>
            </span>
          </div>

           <div class="form-group">
            <label for="name">Quantity in stock(in bags) :</label>
            <input
              type="number"
              v-model="field.quantity_in_stock"
              class="form-control"
              id="cost_per_bag"
              name="quantity_in_stock"
              placeholder="Enter quantiity in stock"
            />

            <span
              class="invalid-feedback alert-danger"
              v-if="'quantity_in_stock' in errors"
              style="display: block"
              role="alert"
            >
              <strong>{{ this.errors.quantity_in_stock[0] }}</strong>
            </span>
          </div>

          <div class="form-group">
            <label for="name">Enter Amount :</label>
            <input
              type="number"
              v-model="field.minimum_quantity"
              class="form-control"
              id="cost_per_bag"
              name="minimum_quantity"
              placeholder="Enter Minimum Quantity Purchasable"
            />

            <span
              class="invalid-feedback alert-danger"
              v-if="'minimum_quantity' in errors"
              style="display: block"
              role="alert"
            >
              <strong>{{ this.errors.minimum_quantity[0] }}</strong>
            </span>
          </div>

          <div class="form-group">
            <label for="name">Total Price (per bag) :</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">₦</span>
              </div>
              <input
                type="number"
                v-model="field.buy_price"
                class="form-control"
                id="cost_of_purchase"
                name="buy_price"
                placeholder="Enter buy price"
              />

              <span
                class="invalid-feedback"
                style="display: block"
                role="alert"
              >
                <strong></strong>
              </span>
            </div>
          </div>

          <div class="form-group mt-5">
            <button type="submit" class="btn btn-success mr-2">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
const Noty = require("noty");
export default {
  mounted() {
      // call to fetch users
      // fet
  },
  data() {
    return {
      field: {
        users: 0,
        user_balance: 0,
        commodity_in_stock: 0,
        commodity_quantity: 0,
        total_price: 0,
      },
      is_processing: false,
      errors: {},
    };
  },
  methods: {
    submitRequest: function (e) {
      e.preventDefault();
      const fileInput = document.querySelector("#upload");
      this.field.commodity_image = fileInput.files[0];
      this.field.sell_price = this.total_sell_price;
      this.field.total_purchase_price = this.total_purchase_price;
      this.field.warehousing = this.total_warehousing_cost;

      var form_data = new FormData();

      for (var key in this.field) {
        form_data.append(key, this.field[key]);
      }

      axios
        .post("/admin/commodity-mgt/add-commodity", form_data)
        .then((res) => {
          if (res.data.status == "success") {
            new Noty({
              type: "success",
              text: res.data.message,
              layout: "bottomRight",
              theme: "bootstrap-v3",
              timeout: 2000,
            }).show();
            setTimeout(() => {
              location.reload();
            }, 3000);
          } else {
            new Noty({
              type: "alert",
              text: res.data.message,
              layout: "bottomRight",
              theme: "bootstrap-v3",
              timeout: 3000,
            }).show();
          }
        })
        .catch((err) => {
          console.log(err.response);
          this.errors = err.response.data.errors ?? {};
          console.log(this.errors);
        });
    },
  },
  computed: {
    total_purchase_price: function () {
      var state_tax = !isNaN(this.field.state_tax)
        ? (this.field.state_tax / 100) * this.field.buy_price
        : 0;
      var transportation = parseFloat(this.field.transportation) || 0;
      var warehousing =
        parseFloat(this.total_warehousing_cost) || parseFloat(0);
      var other_cost = parseFloat(this.field.other_cost) || parseFloat(0);
      var buy_price = parseFloat(this.field.buy_price) || parseFloat(0);
      var value =
        buy_price +
        parseFloat(state_tax) +
        transportation +
        warehousing +
        other_cost;
      if (this.field.warehousing == "NaN") {
        console.log("is nan");
      }

      return !isNaN(value) ? value : 0;
    },

    total_sell_price: function () {
      var percent =
        (this.field.profit_percentage / 100) * this.total_purchase_price;
      return this.total_purchase_price + percent;
    },
    total_warehousing_cost: function () {
      var warehousing_per_month =
        parseFloat(this.field.warehousing_per_month) || parseFloat(0);
      var month_duration = parseFloat(this.field.duration) || parseFloat(0);
      var total = warehousing_per_month * month_duration;

      return total;
    },
  },
};
</script>
