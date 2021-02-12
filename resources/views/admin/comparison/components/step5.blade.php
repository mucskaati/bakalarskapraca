<div v-if="show_third_step">
<div class="row d-flex justify-content-center mt-5">
    <div class="col-12 col-md-12 text-center">
        <h5>5. KROK</h5>
    </div>
</div>
<div v-for="(input, index) in form.graphs" :key="index" v-if="form.graphs.length > 0">
<div class="row d-flex align-items-center justify-content-center mt-5">
    <div class="col-md-12 text-center">
        <h3>
            Graf @{{ index+1 }}
        </h3>
    </div>
    <div class="col-6 col-md-2 justify-content-end">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('annotation_title'+index), 'has-success': fields.annotation_title+index && fields.annotation_title.valid+index }">
            <label :for="'annotation_title'+index" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.annotation_title') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <input type="text" v-model="form.graphs[index].annotation_title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('annotation_title'+index), 'form-control-success': fields.annotation_title+index && (fields.annotation_title+index).valid}" :id="'annotation_title'+index" :name="'annotation_title'+index" placeholder="{{ trans('admin.experiment.columns.annotation_title') }}">
                <div v-if="errors.has('annotation_title'+index)" class="form-control-feedback form-text" v-cloak>@{{ errors.first('annotation_title'+index) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2 justify-content-center justify-content-center text-center">
        <div class="form-group row align-items-center justify-content-center" :class="{'has-danger': errors.has('align' + index), 'has-success': fields.align+index && (fields.align+index).valid }">
            <label :for="'annotation_title' + index" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.align') }}</label>
        </div>
        <div class="form-group row align-items-center justify-content-center" :class="{'has-danger': errors.has('align'), 'has-success': fields.align && fields.align.valid }">
            <input :id="'left'+ index" type="radio" value="left" class="mr-2" v-model="form.graphs[index].align"> 
            <label :for="'left'+ index">Doľava</label>
        </div>
        <div class="form-group row align-items-center justify-content-center" :class="{'has-danger': errors.has('align'), 'has-success': fields.align && fields.align.valid }">
            <input :id="'center'+ index" type="radio" value="center" class="mr-2" v-model="form.graphs[index].align"> 
            <label :for="'center'+ index">Na stred</label>
        </div>
        <div class="form-group row align-items-center justify-content-center" :class="{'has-danger': errors.has('align'), 'has-success': fields.align && fields.align.valid }">
            <input :id="'right'+ index" type="radio" value="right" class="mr-2" v-model="form.graphs[index].align"> 
            <label :for="'right'+ index">Doprava</label>
        </div>
    </div>
    <div class="col-6 col-md-2 justify-content-end">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('annotation_angle'+index), 'has-success': (fields.annotation_angle)+index && (fields.annotation_angle+index).valid }">
            <label :for="'annotation_angle' + index" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.annotation_angle') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <input type="text" v-model="form.graphs[index].annotation_angle" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('annotation_angle'+index), 'form-control-success': fields.annotation_angle+index && (fields.annotation_angle+index).valid}" :id="'annotation_angle'+index" :name="'annotation_angle'+index" placeholder="{{ trans('admin.experiment.columns.annotation_angle') }}">
                <div v-if="errors.has('annotation_angle'+index)" class="form-control-feedback form-text" v-cloak>@{{ errors.first('annotation_angle'+index) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2 justify-content-end">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('xaxis'+index), 'has-success': fields.xaxis+index && (fields.xaxis+index).valid }">
            <label :for="'xaxis' + index" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.xaxis') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <input type="text" v-model="form.graphs[index].xaxis" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('xaxis'+index), 'form-control-success': fields.xaxis+index && (fields.xaxis+index).valid}" :id="'xaxis'+index" :name="'xaxis' + index" placeholder="{{ trans('admin.experiment.columns.xaxis') }}">
                <div v-if="errors.has('xaxis'+index)" class="form-control-feedback form-text" v-cloak>@{{ errors.first('xaxis'+index) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2 justify-content-end">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('yaxis'+index), 'has-success': fields.yaxis+index && (fields.yaxis+index).valid }">
            <label :for="'yaxis' + index" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.yaxis') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <input type="text" v-model="form.graphs[index].yaxis" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('yaxis'+index), 'form-control-success': fields.yaxis+index && (fields.yaxis+index).valid}" :id="'yaxis'+index" :name="'yaxis' + index" placeholder="{{ trans('admin.experiment.columns.yaxis') }}">
                <div v-if="errors.has('yaxis'+index)" class="form-control-feedback form-text" v-cloak>@{{ errors.first('yaxis'+index) }}</div>
            </div>
        </div>
    </div>
</div>
<div v-for="(traceInput, traceIndex) in form.graphs[index].traces" v-if="form.graphs[index].traces.length > 0">
    <hr>
    <div class="row align-items-center">
        <div class="col-12 col-md-12 text-center">
            <h6>Stopa @{{ traceIndex+1 }}</h6>
        </div>
        <div class="col-12 col-md-2">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('traces_title'+traceIndex + index), 'has-success': fields.traces_title+traceIndex+index && (fields.traces_title+traceIndex+index).valid }">
                <label :for="'traces_title' + traceIndex + index" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.traces_title') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                    <input type="text" v-model="form.graphs[index].traces[traceIndex].title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('traces_title'+traceIndex+index), 'form-control-success': fields.traces_title+traceIndex+index && (fields.traces_title+traceIndex+index).valid}" :id="'traces_title' + traceIndex+ index" :name="'traces_title'+traceIndex+index" placeholder="{{ trans('admin.experiment.columns.traces_title') }}">
                    <div v-if="errors.has('traces_title'+traceIndex+index)" class="form-control-feedback form-text" v-cloak>@{{ errors.first('traces_title' + traceIndex+index) }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('xaxis'+traceIndex+index), 'has-success': fields.xaxis+traceIndex+index && (fields.xaxis+traceIndex+index).valid }">
                <label :for="'xaxis'+traceIndex+index" class="col-12 col-form-label">{{ trans('admin.experiment.columns.response_xaxis') }}</label>
                    <div class="col-12">
                        <multiselect v-model="form.graphs[index].traces[traceIndex].xaxis" :options="responses" placeholder="{{ trans('admin.experiment.columns.response_xaxis') }}" label="title" track-by="id" :multiple="false"></multiselect>
                    <div v-if="errors.has('xaxis'+traceIndex+index)" class="form-control-feedback form-text" v-cloak>@{{ errors.first('xaxis'+traceIndex+index) }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('yaxis'+traceIndex+index), 'has-success': fields.yaxis+traceIndex+index && (fields.yaxis+traceIndex+index).valid }">
                <label :for="'yaxis'+traceIndex+index" class="col-12 col-form-label">{{ trans('admin.experiment.columns.response_yaxis') }}</label>
                    <div class="col-12">
                        <multiselect v-model="form.graphs[index].traces[traceIndex].yaxis" :options="responses" placeholder="{{ trans('admin.experiment.columns.response_yaxis') }}" label="title" track-by="id" :multiple="false"></multiselect>
                    <div v-if="errors.has('yaxis'+traceIndex+index)" class="form-control-feedback form-text" v-cloak>@{{ errors.first('yaxis'+traceIndex+index) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="text-center">
                <button type="submit" class="btn btn-danger" @click.prevent="deleteTraceFromGraph(index, traceIndex)">Zmazať stopu</button>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 text-center">
    <button type="submit" class="btn btn-success" @click.prevent="addTraceToGraph(index)">Pridať stopu</button>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('template'), 'has-success': fields.template && fields.template.valid }">
            <label for="template" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.template') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <div>
                    <prism-editor class="my-editor" v-model="form.template" :highlight="highlighter" line-numbers></prism-editor>
                </div>
                <div v-if="errors.has('template')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('template') }}</div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('custom_js'), 'has-success': fields.custom_js && fields.custom_js.valid }">
            <label for="custom_js" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.custom_js') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <div>
                    <wysiwyg v-model="form.custom_js" v-validate="" id="custom_js" name="custom_js" :config="mediaWysiwygConfig"></wysiwyg>
                </div>
                <div v-if="errors.has('custom_js')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('custom_js') }}</div>
            </div>
        </div>
    </div>
</div> --}}
</div>