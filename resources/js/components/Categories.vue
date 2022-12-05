<template>
  <div class="container">
    <div class="row">
      <div class="text-center">
        <div class="spinner-border" role="status" v-if="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <h1>Категории</h1>
        <button @click="created = true" type="button" class="btn btn-primary float-right" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#categoryModal">Добавить</button>
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
          <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in categories">
          <th scope="row">{{ item.id }}</th>
          <td>
            <h4 class="card-title">{{ item.parent_id}}-{{ item.name }}</h4>
          </td>
          <td>
            <button @click="getOneCategory(item.id)" class="btn btn-primary btn-sm" style="cursor: pointer" aria-hidden="true" type="button" data-bs-toggle="modal" data-bs-target="#categoryModal">
              <i class="fa fa-pencil cursor-p mr-3"  title="Редактировать"></i>
            </button>

            <button @click="deleteCategory(item.id)" type="button" class="btn btn-danger btn-sm" style="cursor: pointer">
              <i class="fa fa-trash" title="Удалить"></i>
            </button>
          </td>
        </tr>

        </tbody>
      </table>

      <!-- Modal -->
      <div  class="modal fade" id="categoryModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="categoryModalLabel"><span v-if="created">Добавить</span><span v-else>Редактировать</span></h1>
              <button @click="getAllCategories" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <form @submit.prevent="saveCategory">

                <div class="mb-3">
                  <label class="form-label">Расположение: {{ current_category.name }}</label>
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
                  <input v-model="current_category.name" type="text" class="form-control" :class="{ 'is-invalid': $v.current_category.name.$error }" placeholder="Введите название">
                    <div class="invalid-feedback" v-if="!$v.current_category.name.required">
                      Обязательное поле.
                    </div>
                    <div class="invalid-feedback" v-if="!$v.current_category.name.maxLength">
                      Макс. количество символов: {{ $v.current_category.name.$params.maxLength.max }}.
                    </div>
                </div>

                <button @click="saveCategory" type="button" class="btn btn-primary float-end">
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
      current_category: {
        id: '',
        parent_id: '',
        name: '',
      },
    }
  },
  mounted() {
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
        this.created = false;
        this.current_category = [];
        this.categories = [];
        this.categories = response.data.data;
      })
      .catch(error => {
        this.errored = true;
        this.message = "Ошибка загрузки данных.";
      })
      .finally(() => {
        this.loading = false;
      });
    },
    getOneCategory(id) {
      axios.get("/api/v1/categories/" + id)
      .then(response => {
        this.current_category = response.data.data;
      })
      .catch(error => {
        this.errored = true;
        this.message = "Ошибка загрузки данных!";
      })
      .finally(() => {
        this.loading = false;
      });
    },
    saveCategory() {
      if (this.created) {
        this.createCategory();
      } else {
        this.updateCategory();
      }
    },
    createCategory() {
      this.$v.$touch()
      if (this.$v.$anyError) {
        return;
      }
      axios.post("/api/v1/categories", {
        parent_id: this.selected,
        name: this.current_category.name,
      })
      .then(response => {
        jQuery("#categoryModal").modal('hide');
        this.successed = true;
        this.message = "Успешно сохранено.";
        this.getAllCategories();
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
    updateCategory() {
      this.$v.$touch()
      if (this.$v.$anyError) {
        return;
      }
      if (this.selected !== '') {
        this.current_category.parent_id = this.selected;
      }
      axios.post("/api/v1/categories/" + this.current_category.id, {
        _method: "PATCH",
        parent_id: this.current_category.parent_id,
        name: this.current_category.name,
      })
      .then(response => {
        jQuery("#categoryModal").modal('hide');
        this.successed = true;
        this.message = "Изменения сохранены.";
        this.getAllCategories();
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
    deleteCategory(id) {
      if (confirm("Удалить категорию?")) {
        axios.post("/api/v1/categories/" + id, {
          _method: "DELETE",
        })
            .then(response => {
              this.successed = true;
              this.message = "Успешно удалено.";
              this.getAllCategories();
            })
            .catch(error => {
              this.errored = true;
              this.message = "Ошибка удаления.";
            })
            .finally(() => {
              this.loading = false;
            });
      }
    },
  },
  validations: {
    current_category: {
      name: {
        required,
        maxLength: maxLength(255),
      },
    },
    selected: {
      required,
    }
  },
}
</script>