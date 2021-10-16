<template>
  <div class="col-10 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Commodity</h4>
        <p class="card-description">Edit Commodity</p>

        <form
          method="POST"
          @submit="submitCommodity($event)"
          action
          enctype="multipart/form-data"
        >
          <div class="form-group">
            <label for="name">Commodity Name :</label>
            <input
              type="text"
              v-model="field.commodity_name"
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
            <label for="name">Minimum Quantity Purchasable( bags ) :</label>
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
            <label for="name">Purchase price (per bag) :</label>
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
          <div class="form-group">
            <label for="name">State Tax (per bag) % :</label>
            <div class="input-group">
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon1">%</span>
              </div>
              <input
                type="number"
                v-model="field.state_tax"
                class="form-control"
                id="state_tax"
                name="state_tax"
                placeholder="Enter state tax"
                step="0.1"
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

          <div class="form-group">
            <label for="name">Transportation (per bag) :</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">₦</span>
              </div>
              <input
                type="number"
                v-model="field.transportation"
                class="form-control"
                id="transportation"
                name="transportation"
                placeholder="Enter Transportation"
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

          <div class="form-group">
            <label for="name">Deal duration(in months) :</label>
            <input
              type="number"
              v-model="field.duration"
              class="form-control"
              id="cost_per_bag"
              name="duration"
              placeholder="Enter deal duration"
            />

            <span
              class="invalid-feedback alert-danger"
              v-if="'duration' in errors"
              style="display: block"
              role="alert"
            >
              <strong>{{ this.errors.duration[0] }}</strong>
            </span>
          </div>

          <div class="form-group">
            <label for="name">Warehousing cost (per bag/ per month) :</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">₦</span>
              </div>
              <input
                type="number"
                v-model="field.warehousing_per_month"
                class="form-control"
                id="warehousing"
                name="warehousing"
                placeholder="Enter warehousing cost"
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

          <div class="form-group">
            <label for="name">Other costs (per bag) :</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">₦</span>
              </div>
              <input
                type="number"
                v-model="field.other_cost"
                class="form-control"
                id="other_cost"
                name="other_cost"
                placeholder="Enter Other cost"
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

          <div class="form-group">
            <label for="name">Total Warehousing cost :</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">₦</span>
              </div>
              <input
                type="number"
                v-model="this.total_warehousing_cost"
                class="form-control"
                id="total_warehousing"
                name="warehousing"
                readonly
                placeholder="Total warehousing cost"
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

          <div class="form-group">
            <label for="name">Total Purchase price (per bag) :</label>

            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">₦</span>
              </div>
              <input
                type="number"
                v-model="this.total_purchase_price"
                class="form-control"
                placeholder="Total price"
                readonly
                aria-describedby="basic-addon1"
              />
            </div>
          </div>

          <div class="form-group">
            <label for="name">Profit Margin(%) :</label>

            <div class="input-group">
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon1">%</span>
              </div>
              <input
                type="number"
                v-model="field.profit_percentage"
                class="form-control"
                id="cost_per_bag"
                name="profit_percentage"
                placeholder="Target sale price"
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

          <div class="form-group">
            <label for="name">Target sale price :</label>
            <div class="input-group">
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon1">₦</span>
              </div>
              <input
                type="number"
                readonly
                v-model="this.total_sell_price"
                class="form-control"
                id="cost_per_bag"
                name="sell_price"
                placeholder="Target sale price"
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

          <div class="form-group">
            <label for="address">Availability :</label>
            <select
              name="availability"
              v-model="field.availability"
              id
              class="form-control"
            >
              <option value="1">Available</option>
              <option value="0">Unavailable</option>
            </select>
          </div>

          <div class="form-group">
            <label for="name">Description :</label>
            <textarea
              name="description"
              v-model="field.description"
              class="form-control"
              id
              cols="30"
              rows="10"
            ></textarea>

            <span
              class="invalid-feedback alert-danger"
              v-if="'description' in errors"
              style="display: block"
              role="alert"
            >
              <strong>{{ this.errors.description[0] }}</strong>
            </span>
          </div>

          <div class="form-group">
            <label for="name">Product Image :</label>
            <div class="profile-image">
              <img :src="commodity_image" alt width="70px" height="70px" />
            </div>
            <input
              type="file"
              id="upload"
              name="commodity_image"
              class="form-control"
            />

            <span
              class="invalid-feedback alert-danger"
              v-if="'commodity_image' in errors"
              style="display: block"
              role="alert"
            >
              <strong>{{ this.errors.commodity_image[0] }}</strong>
            </span>
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
  props: ["commodity"],
  mounted() {},
  data() {
    return {
      commodity_image: JSON.parse(this.commodity).product_image,
      field: {
        commodity_name: JSON.parse(this.commodity).commodity_name,
        buy_price: JSON.parse(this.commodity).buy_price,
        total_purchase_price: JSON.parse(this.commodity).purchase_price,
        quantity_in_stock: JSON.parse(this.commodity).quantity_in_stock,
        state_tax: JSON.parse(this.commodity).state_tax,
        transportation: JSON.parse(this.commodity).transportation,
        warehousing_per_month:
          JSON.parse(this.commodity).warehousing /
          JSON.parse(this.commodity).duration,
        other_cost: JSON.parse(this.commodity).other_costs,
        profit_percentage: JSON.parse(this.commodity).profit_margin,
        availability: JSON.parse(this.commodity).availability,
        description: JSON.parse(this.commodity).description,
        sell_price: JSON.parse(this.commodity).sell_price,
        duration: JSON.parse(this.commodity).duration,
        total_warehousing_cost: JSON.parse(this.commodity).warehousing,
        minimum_quantity: JSON.parse(this.commodity).minimum_quantity,
      },
      is_processing: false,
      errors: {},
    };
  },
  methods: {
    submitCommodity: function (e) {
      e.preventDefault();
      const fileInput = document.querySelector("#upload");
      if (fileInput.files[0]) {
        this.field.commodity_image = fileInput.files[0];
      }

      this.field.sell_price = this.total_sell_price;
      this.field.total_purchase_price = this.total_purchase_price;
      this.field.warehousing = this.total_warehousing_cost;
      var form_data = new FormData();

      for (var key in this.field) {
        form_data.append(key, this.field[key]);
      }

      axios
        .post(
          `/admin/commodity-mgt/${
            JSON.parse(this.commodity).id
          }/edit-commodity`,
          form_data
        )
        .then((res) => {
          if (res.data.status == "success") {
            new Noty({
              type: "success",
              text: res.data.message,
              layout: "bottomRight",
              theme: "bootstrap-v3",
              timeout: 3000,
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
              timeout: 2000,
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
      console.log(transportation);
      console.log(warehousing);
      console.log(value);
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

<style>
</style>

