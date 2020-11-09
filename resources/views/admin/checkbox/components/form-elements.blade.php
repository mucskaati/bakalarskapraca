<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_name'), 'has-success': fields.attribute_name && fields.attribute_name.valid }">
    <label for="attribute_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.checkbox.columns.attribute_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_name'), 'form-control-success': fields.attribute_name && fields.attribute_name.valid}" id="attribute_name" name="attribute_name" placeholder="{{ trans('admin.checkbox.columns.attribute_name') }}">
        <div v-if="errors.has('attribute_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('layout_id'), 'has-success': fields.layout_id && fields.layout_id.valid }">
    <label for="layout_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.checkbox.columns.layout_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.layout_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('layout_id'), 'form-control-success': fields.layout_id && fields.layout_id.valid}" id="layout_id" name="layout_id" placeholder="{{ trans('admin.checkbox.columns.layout_id') }}">
        <div v-if="errors.has('layout_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('layout_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
    <label for="title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.checkbox.columns.title') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.checkbox.columns.title') }}">
        <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
    </div>
</div>


