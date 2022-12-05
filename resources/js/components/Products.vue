<template>
  <div class="container">
    <div class="row">
      <div class="text-center">
        <div class="spinner-border" role="status" v-if="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <h1>Товары</h1>
        <button @click="created = true" type="button" class="btn btn-primary float-right" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#productModal">Добавить
        </button>
      </div>

      <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="successed">
        {{ message }}
        <button @click="successed = false" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>

      <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="errored">
        {{ message }}<br>
        <span v-html="errors"></span>
        <button @click="errored = false" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>

      <table class="table">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Название</th>
          <th scope="col">Категория</th>
          <th scope="col">Цена</th>
          <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in products">
          <th scope="row">{{ item.id }}</th>
          <td>
            <h4 class="card-title">{{ item.name }}</h4>
          </td>
          <td>
            {{ item.category.name }}
          </td>
          <td>
            {{ item.price }}
          </td>
          <td>
            <button @click="getOneProduct(item.id)" class="btn btn-primary btn-sm" style="cursor: pointer" aria-hidden="true" type="button" data-bs-toggle="modal" data-bs-target="#productModal">
              <i class="fa fa-pencil cursor-p mr-3" title="Редактировать"></i>
            </button>

            <button @click="deleteProduct(item.id)" type="button" class="btn btn-danger btn-sm" style="cursor: pointer">
              <i class="fa fa-trash" title="Удалить"></i>
            </button>
          </td>
        </tr>

        </tbody>
      </table>

      <!-- Modal -->
      <div class="modal fade" id="productModal" data-bs-backdrop="static" tabindex="-1"
           aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="productModalLabel"><span v-if="created">Добавить</span><span v-else>Редактировать</span>
              </h1>
              <button @click="getAllProducts" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span v-if="errored">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="errored">
                {{ message }}<br>
                  <span v-html="errors"></span>
                <button @click="errored = false" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              </span>
              <span v-else>
                <form @submit.prevent="saveProduct">

                <div class="mb-3">
                  <input v-model="current_product.name" type="text" class="form-control" :class="{ 'is-invalid': $v.current_product.name.$error }" placeholder="Введите название">
                  <div class="invalid-feedback" v-if="!$v.current_product.name.required">
                    Обязательное поле.
                  </div>
                  <div class="invalid-feedback" v-if="!$v.current_product.name.maxLength">
                    Макс. количество символов: {{ $v.current_product.name.$params.maxLength.max }}.
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Расположение: {{ current_product.category_name }}</label>
                  <select v-model="selected" class="form-select" :class="{ 'is-invalid': $v.selected.$error }">
                    <option value="0">- Корневой уровень -</option>
                    <option v-for="it in categories" :value="it.id">
                      {{ it.name }}
                    </option>
                  </select>
                    <div class="invalid-feedback" v-if="!$v.selected.required">
                      Обязательное поле.
                    </div>
                </div>

                <div class="mb-3">
                  <input v-model="current_product.price" type="text" class="form-control" :class="{ 'is-invalid': $v.current_product.price.$error }" placeholder="Введите цену">
                  <div class="invalid-feedback" v-if="!$v.current_product.price.required">
                    Обязательное поле.
                  </div>
                </div>

                <button @click="saveProduct" type="button" class="btn btn-primary float-end">
                  <span v-if="created">Добавить</span><span v-else>Сохранить</span>
                </button>
              </form>
              </span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import {required, maxLength} from 'vuelidate/lib/validators';

export default {
  data() {
    return {
      loading: true,
      successed: false,
      errored: false,
      created: false,
      errors: '',
      selected: '',
      message: '',
      categories: [],
      products: [],
      current_product: {
        id: '',
        category_id: '',
        name: '',
        price: '',
        category_name: '',
      },
    }
  },
  mounted() {
    this.getAllProducts();
    this.getAllCategories();
  },
  methods: {
    getErrors(error) {
      this.errors = '';
      if (error.response.data.errors.name) {
        let data = error.response.data.errors;
        for (let key in data) {
          this.errors += data[key] + "<br>";
        }
      }
    },
    getAllCategories() {
      axios.get("/api/v1/categories")
          .then(response => {
            this.categories = response.data.data;
          })
          .catch(error => {
            this.errored = true;
            this.message = "Ошибка загрузки данных";
          })
          .finally(() => {
            this.loading = false;
          });
    },
    getAllProducts() {
      axios.get("/api/v1/products")
          .then(response => {
            this.created = false;
            this.current_product = [];
            this.products = [];
            this.products = response.data.data;
          })
          .catch(error => {
            this.errored = true;
            this.message = "Ошибка загрузки данных";
          })
          .finally(() => {
            this.loading = false;
          });
    },
    getOneProduct(id) {
      axios.get("/api/v1/products/" + id)
          .then(response => {
            let data = response.data.data;
            this.current_product = data;
            this.current_product.category_name = data.category.name;
          })
          .catch(error => {
            this.errored = true;
            this.message = "Ошибка загрузки данных!";
          })
          .finally(() => {
            this.loading = false;
          })
    },
    saveProduct() {
      if (this.created) {
        this.createProduct();
      } else {
        this.updateProduct();
      }
    },
    updateProduct() {
      this.$v.$touch()
      if (this.$v.$anyError) {
        return;
      }
      if (this.selected !== '') {
        this.current_product.category_id = this.selected;
      }
      axios.post("/api/v1/products/" + this.current_product.id, {
        _method: "PATCH",
        category_id: this.current_product.category_id,
        name: this.current_product.name,
        price: this.current_product.price,
      })
          .then(response => {
            jQuery("#productModal").modal('hide');
            this.successed = true;
            this.message = "Изменения сохранены";
            this.getAllProducts();
          })
          .catch(error => {
            this.errored = true;
            this.getErrors(error);
            this.message = "Ошибка загрузки данных!";
          })
          .finally(() => {
            this.loading = false;
          })
    },
    createProduct() {
      this.$v.$touch();
      if (this.$v.$anyError) {
        return;
      }
      axios.post("/api/v1/products", {
        category_id: this.selected,
        name: this.current_product.name,
        price: this.current_product.price,
      })
      .then(response => {
        jQuery("#productModal").modal("hide");
        this.successed = true;
        this.message = "Успешно сохранено";
        this.getAllProducts();
      })
      .catch(error => {
        this.errored = true;
        this.getErrors(error);
        this.message = "Ошибка загрузки данных!";
      })
      .finally(() => {
        this.loading = false;
      });
    },
    deleteProduct(id) {
      if (confirm("Удалить товар?")) {
        axios.post("/api/v1/products/" + id, {
          _method: "DELETE",
        })
        .then(response => {
          this.successed = true;
          this.message = "Успешно удалено.";
          this.getAllProducts();
        })
        .catch(error => {
          this.errored = true;
          this.message = "Ошибка удаления!";
        })
        .finally(() => {
          this.loading = false;
        });
      }
    },
  },
  validations: {
    current_product: {
      name: {
        required,
        maxLength: maxLength(255),
      },
      price: {
        required,
      }
    },
    selected: {
      required,
    }
  },
}
</script>