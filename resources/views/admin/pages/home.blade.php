@extends("admin.layouts.master")

@section('extraCss')
    <link rel="stylesheet" href="{{ asset("css/templates/grid.css") }}" />
@endsection

@section('content')
    <div class="row" id="rssFeedForm">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h4>RSS Feed to HTML Convert Tool</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="submitForm" action="">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Url</label>
                                <select :class="{'is-invalid': form.errors.has('url')}" class="form-control"
                                v-model="form.url">
                                <option value="" hidden disabled>Select RSS url</option>
                                @foreach ($rssUrls as $url)
                                    <option value="{{ $url->url }}">{{ $url->url }}</option>
                                @endforeach
                                </select>
                                <has-error :form="form" field="url" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="">Output type</label>
                                <select v-model="form.type" class="form-control">
                                    <option value="grid">Grid</option>
                                    <option value="masonry">Masonry</option>
                                    <option value="carousel">Carousel</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-3 form-group">
                                <label for="">Number of column</label>
                                <input type="number" placeholder="Input how much data you want to show in each row" class="form-control"
                                v-model="form.column">
                            </div>
                            <div class="col-md-2 col-3 form-group">
                                <label for="">Number of rows</label>
                                <input type="number" placeholder="Input how many lines you want to show" class="form-control"
                                v-model="form.row">
                            </div>
                            <div class="col-md-12 form-group">
                                <form-button :form="form" type="submit" 
                                class="btn btn-success">Generate HTML</form-button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="row mt-3">
                        <div class="mb-4" :class="expanded==true?'col-md-12':'col-md-6'">
                            <h4>Preview</h4>
                            <hr>
                            <div class="col-12 mb-3">
                                <button v-if="!expanded" @click="expanded=true;" class="btn btn-secondary btn-sm">
                                <i class="fas fa-expand-arrows-alt"></i> Expand</button>
                                <button v-else @click="expanded=false;" class="btn btn-secondary btn-sm">
                                <i class="fas fa-hand"></i> Collapse</button>
                            </div>

                            <template v-cloak v-if="form.type == 'carousel'">
                                <div class="text-center">
                                    <h3 style="max-width: 400px;margin-top:50px;margin: 0 auto;font-family: 'Segoe UI';line-height:1.2;line-height: 1.5;color: #8f8f8f;" 
                                    class="mt-5">
                                    <button @click="openCarouselPrev" class="btn btn-primary">Open Carousel Preview</button>
                                    </h3>
                                </div>
                            </template>

                            <template v-cloak v-else>
                                <div v-html="html">

                                </div> 
                            </template>

                        </div>
                        <div class="mb-4" :class="expanded==true?'col-md-12':'col-md-6'">
                            <h4>Source Code (HTML + Css)</h4>
                            <hr>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <div class="btn-group btn-group-toggle ml-2" data-toggle="buttons">
                                        <label class="btn btn-outline-danger btn-sm active">
                                            <input @change="toggleCode('html')" type="radio" name="options" autocomplete="off" checked> HTML
                                        </label>
                                        <label class="btn btn-outline-danger btn-sm">
                                            <input @change="toggleCode('css')" type="radio" name="options" autocomplete="off"> CSS
                                        </label>
                                        <label class="btn btn-outline-danger btn-sm">
                                            <input @change="toggleCode('js')" type="radio" name="options" autocomplete="off"> JS
                                        </label>
                                    </div>
                                    <button v-cloak v-if="result != ''" @click="copyCode" class="btn-sm btn-copy">Copy &nbsp;<i class="fas fa-copy"></i></button>
                                </div>
                                <div class="col-12">
                                    <highlightjs :language='lang' :code="result" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection