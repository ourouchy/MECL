<template>
  <div>
    <label class="sr-only">{{ label }}</label>
    <div class="mt-1 flex rounded-md" :class="type === 'checkbox' ? 'items-center' : 'shadow-sm'">
      <span v-if="prepend"
            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
        {{ prepend }}
      </span>
      <template v-if="type === 'select'">
        <select :name="name"
                :required="required"
                :value="props.modelValue"
                :class="inputClasses"
                :disabled="disabled"
                @change="onChange($event.target.value)">
          <option v-for="option of selectOptions" :value="option.key">{{ option.text }}</option>
        </select>
      </template>
      <template v-else-if="type === 'textarea'">
        <textarea :name="name"
                  :required="required"
                  :value="props.modelValue"
                  @input="emit('update:modelValue', $event.target.value)"
                  :class="inputClasses"
                  :placeholder="label"
                  :disabled="disabled"></textarea>
      </template>
      <template v-else-if="type === 'richtext'">
        <ckeditor :editor="editor"
                  :required="required"
                  :model-value="props.modelValue"
                  @input="onChange"
                  :class="inputClasses"
                  :config="editorConfig"
                  :disabled="disabled"></ckeditor>
      </template>
      <template v-else-if="type === 'file'">
        <input :type="type"
               :name="name"
               :required="required"
               :value="props.modelValue"
               @input="emit('change', $event.target.files[0])"
               :class="inputClasses"
               :placeholder="label"
               :disabled="disabled"/>
      </template>
      <template v-else-if="type === 'checkbox'">
        <input :id="id"
               :name="name"
               :type="type"
               :checked="props.modelValue"
               :required="required"
               @change="emit('update:modelValue', $event.target.checked)"
               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
               :disabled="disabled"/>
        <label :for="id" class="ml-2 block text-sm text-gray-900"> {{ label }} </label>
      </template>
      <template v-else>
        <input :type="type"
               :name="name"
               :required="required"
               :value="props.modelValue"
               @input="emit('update:modelValue', $event.target.value)"
               :class="inputClasses"
               :placeholder="label"
               step="0.01"
               :disabled="disabled"/>
      </template>
      <span v-if="append"
            class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
        {{ append }}
      </span>
    </div>
    <small v-if="errors && errors[0]" class="text-red-600">{{ errors[0] }}</small>
  </div>
</template>

<script setup>
import { computed } from "vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const editor = ClassicEditor;

const props = defineProps({
  modelValue: [String, Number, File],
  label: String,
  type: {
    type: String,
    default: 'text'
  },
  name: String,
  required: Boolean,
  prepend: {
    type: String,
    default: ''
  },
  append: {
    type: String,
    default: ''
  },
  selectOptions: Array,
  errors: {
    type: Array,
    required: false
  },
  editorConfig: {
    type: Object,
    default: () => ({})
  },
  disabled: {              // New disabled prop
    type: Boolean,
    default: false
  }
});

const id = computed(() => {
  if (props.id) return props.id;
  return `id-${Math.floor(1000000 + Math.random() * 1000000)}`;
});
const inputClasses = computed(() => {
  const cls = [
    `block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm`,
  ];

  if (props.append && !props.prepend) {
    cls.push(`rounded-l-md`)
  } else if (props.prepend && !props.append) {
    cls.push(`rounded-r-md`)
  } else if (!props.prepend && !props.append) {
    cls.push('rounded-md')
  }
  if (props.errors && props.errors[0]) {
    cls.push('border-red-600 focus:border-red-600')
  }
  return cls.join(' ')
});
const emit = defineEmits(['update:modelValue', 'change']);

function onChange(value) {
  emit('update:modelValue', value);
  emit('change', value);
}
</script>

<style scoped>
/deep/ .ck-editor {
  width: 100%;
}

/deep/ .ck-content {
  min-height: 200px;
}
</style>
