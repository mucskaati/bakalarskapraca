<div class="row d-flex justify-content-center">
    <div class="col-12 col-md-12 text-center">
        <h5>3. KROK</h5>
    </div>
</div>
<div class="row d-flex align-items-center justify-content-center mt-5" v-for="(input, index) in form.graphs" :key="index" v-if="form.graphs.length > 0">
    <div class="col-md-12 text-center">
        <h3>
            Graf @{{ index+1 }}
        </h3>
    </div>
    <div class="col-6 col-md-2 justify-content-end">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('annotation_title'), 'has-success': fields.annotation_title && fields.annotation_title.valid }">
            <label for="annotation_title" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.annotation_title') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <input type="text" v-model="form.graphs[index].annotation_title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('annotation_title'), 'form-control-success': fields.annotation_title && fields.annotation_title.valid}" id="annotation_title" name="annotation_title" placeholder="{{ trans('admin.experiment.columns.annotation_title') }}">
                <div v-if="errors.has('annotation_title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('annotation_title') }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2 justify-content-center justify-content-center text-center">
        <div class="form-group row align-items-center justify-content-center" :class="{'has-danger': errors.has('align'), 'has-success': fields.align && fields.align.valid }">
            <label for="annotation_title" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.align') }}</label>
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
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('annotation_angle'), 'has-success': fields.annotation_angle && fields.annotation_angle.valid }">
            <label for="annotation_angle" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.annotation_angle') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <input type="text" v-model="form.graphs[index].annotation_angle" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('annotation_angle'), 'form-control-success': fields.annotation_angle && fields.annotation_angle.valid}" id="annotation_angle" name="annotation_angle" placeholder="{{ trans('admin.experiment.columns.annotation_angle') }}">
                <div v-if="errors.has('annotation_angle')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('annotation_angle') }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2 justify-content-end">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('xaxis'), 'has-success': fields.xaxis && fields.xaxis.valid }">
            <label for="xaxis" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.xaxis') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <input type="text" v-model="form.graphs[index].xaxis" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('xaxis'), 'form-control-success': fields.xaxis && fields.xaxis.valid}" id="xaxis" name="xaxis" placeholder="{{ trans('admin.experiment.columns.xaxis') }}">
                <div v-if="errors.has('xaxis')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('xaxis') }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2 justify-content-end">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('yaxis'), 'has-success': fields.yaxis && fields.yaxis.valid }">
            <label for="yaxis" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.yaxis') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <input type="text" v-model="form.graphs[index].yaxis" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('yaxis'), 'form-control-success': fields.yaxis && fields.yaxis.valid}" id="yaxis" name="yaxis" placeholder="{{ trans('admin.experiment.columns.yaxis') }}">
                <div v-if="errors.has('yaxis')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('yaxis') }}</div>
            </div>
        </div>
    </div>
    <div class="row" v-for="(traceInput, traceIndex) in form.graphs[index].traces" v-if="form.graphs[index].traces.length > 0">
        <div class="col-6 col-md-3">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('traces_title'), 'has-success': fields.traces_title && fields.traces_title.valid }">
                <label for="traces_title" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.traces_title') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                    <input type="text" v-model="form.graphs[index].traces[index].title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('traces_title'), 'form-control-success': fields.traces_title && fields.traces_title.valid}" id="traces_title" name="traces_title" placeholder="{{ trans('admin.experiment.columns.traces_title') }}">
                    <div v-if="errors.has('traces_title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('traces_title') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-success" @click.prevent="addTraceToGraph(index)">Pridať stopu</button>
    </div>
</div>