<div class="row">
    <div class="offset-md-2 col-4">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
            <label for="name" class="col-12 col-form-label text-md-left">{{ trans('admin.layout.columns.name') }}</label>
                <div :class="'col-12'">
                <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.layout.columns.name') }}">
                <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
            </div>
        </div>

        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('height'), 'has-success': fields.height && fields.height.valid }">
            <label for="height" class="col-12 col-form-label text-md-left">{{ trans('admin.layout.columns.height') }}</label>
                <div :class="'col-12'">
                <input type="text" v-model="form.height" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('height'), 'form-control-success': fields.height && fields.height.valid}" id="height" name="height" placeholder="{{ trans('admin.layout.columns.height') }}">
                <div v-if="errors.has('height')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('height') }}</div>
            </div>
        </div>

        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('width'), 'has-success': fields.width && fields.width.valid }">
            <label for="width" class="col-12 col-form-label text-md-left">{{ trans('admin.layout.columns.width') }}</label>
                <div :class="'col-12'">
                <input type="text" v-model="form.width" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('width'), 'form-control-success': fields.width && fields.width.valid}" id="width" name="width" placeholder="{{ trans('admin.layout.columns.width') }}">
                <div v-if="errors.has('width')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('width') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('margin'), 'has-success': fields.margin && fields.margin.valid }">
            <label for="margin" class="col-12 col-form-label text-md-left">{{ trans('admin.layout.columns.margin') }}</label>
                <div :class="'col-12'">
                <input type="text" v-model="form.margin" v-validate="" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('margin'), 'form-control-success': fields.margin && fields.margin.valid}" id="margin" name="margin" placeholder="{{ trans('admin.layout.columns.margin') }}">
                <div v-if="errors.has('margin')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('margin') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('xaxis'), 'has-success': fields.xaxis && fields.xaxis.valid }">
            <label for="xaxis" class="col-12 col-form-label text-md-left">{{ trans('admin.layout.columns.xaxis') }}</label>
                <div :class="'col-12'">
                <input type="text" v-model="form.xaxis" v-validate="" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('xaxis'), 'form-control-success': fields.xaxis && fields.xaxis.valid}" id="xaxis" name="xaxis" placeholder="{{ trans('admin.layout.columns.xaxis') }}">
                <div v-if="errors.has('xaxis')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('xaxis') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('yaxis'), 'has-success': fields.yaxis && fields.yaxis.valid }">
            <label for="yaxis" class="col-12 col-form-label text-md-left">{{ trans('admin.layout.columns.yaxis') }}</label>
                <div :class="'col-12'">
                <input type="text" v-model="form.yaxis" v-validate="" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('yaxis'), 'form-control-success': fields.yaxis && fields.yaxis.valid}" id="yaxis" name="yaxis" placeholder="{{ trans('admin.layout.columns.yaxis') }}">
                <div v-if="errors.has('yaxis')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('yaxis') }}</div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
            <label for="type" class="col-12 col-form-label text-md-left">{{ trans('admin.layout.columns.type') }}</label>
                <div class="col-md-4 text-center">
                <label for="type" class="col-form-label text-md-center">{{ __('admin.layout.columns.type_fo') }}</label>
                    <div>
                        <input type="radio" v-model="form.type" value="fo">
                        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <label for="type" class="col-form-label text-md-center">Nyquist</label>
                        <div>
                            <input type="radio" v-model="form.type" value="nyquist">
                            <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
                        </div>
                </div>
                <div class="col-md-4 text-center">
                    <label for="type" class="col-form-label text-md-center">{{ __('admin.layout.columns.type_comparison') }}</label>
                        <div>
                            <input type="radio" v-model="form.type" value="porovnanie">
                            <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
                        </div>
                </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('rows'), 'has-success': fields.rows && fields.rows.valid }">
            <label for="rows" class="col-12 col-form-label text-md-left">{{ trans('admin.layout.columns.rows') }}</label>
                <div :class="'col-12'">
                <input type="text" v-model="form.rows" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('rows'), 'form-control-success': fields.rows && fields.rows.valid}" id="rows" name="rows" placeholder="{{ trans('admin.layout.columns.rows') }}">
                <div v-if="errors.has('rows')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('rows') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('columns'), 'has-success': fields.columns && fields.columns.valid }">
            <label for="columns" class="col-12 col-form-label text-md-left">{{ trans('admin.layout.columns.columns') }}</label>
                <div class="col-12">
                <input type="text" v-model="form.columns" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('columns'), 'form-control-success': fields.columns && fields.columns.valid}" id="columns" name="columns" placeholder="{{ trans('admin.layout.columns.columns') }}">
                <div v-if="errors.has('columns')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('columns') }}</div>
            </div>
        </div>
    </div>
</div>


