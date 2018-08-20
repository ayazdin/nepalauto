<?php
$epaper_month="";$epaper_year=""; $epaper_pdf="";
if(!empty($editepaper))
{
    $postmeta = $editepaper->postmeta;
    foreach($postmeta as $pm)
    {
        if($pm->meta_key=='epaper_month')
            $epaper_month = $pm->meta_value;
        if($pm->meta_key=='epaper_year')
            $epaper_year = $pm->meta_value;
        if($pm->meta_key=='epaper_pdf')
            $epaper_pdf = $pm->meta_value;

    }
}
?>

@extends('admin.layouts.admin-app')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row">
                <div class="col-sm-8 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">E-paper</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            @if(!empty($succ))
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Success!</strong> {{ $succ }}
                                    </div>
                                @endif
                                @if(!empty(session('succ')))
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Success!</strong> {{ session('succ') }}
                                    </div>
                                @endif
                            <table class="table table-hover">
                                <tr>
                                    <th>Title</th>
                                    <th>Year - month</th>
                                    <th></th>
                                </tr>
                                @if(!empty($epapers))
                                    @foreach($epapers as $epaper)
                                    <tr>
                                        <td>{{$epaper->title}}</td>
                                            <?php 
                                                $relatedMetas = $epaper->postmeta;
                                                $relatedepaper_month="";$relatedepaper_year="";
                                                foreach ($relatedMetas as $relatedmeta) {
                                                    if($relatedmeta->meta_key=='epaper_month')
                                                        $relatedepaper_month = $relatedmeta->meta_value;

                                                    if($relatedmeta->meta_key=='epaper_year')
                                                        $relatedepaper_year = $relatedmeta->meta_value;
                                                }
                                            ?>
                                            <td>
                                                <?php echo $relatedepaper_year.' - '.$relatedepaper_month;?>
                                            </td>
                                        <td>
                                            <a href="/admin/e-paper/{{$epaper->id}}">Edit</a> |
                                            <a href="/admin/e-paper/delete/{{$epaper->id}}">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2"> No items</td>

                                    </tr>
                                @endif
                            </table>
                        </div>


                    </div>
                </div>

                <div class="col-sm-4 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Brands</h3>
                        </div>
                        <form class="form-horizontal" name="frmAddCategory" id="frmAddCategory"
                              action="/admin/e-paper/store" method="post">
                            {!! csrf_field() !!}

                            @if(!empty($editepaper))
                                <input type="hidden" name="epaperid" value="{{ $editepaper->id }}">
                            @endif


                            <div class="box-body">

                                <div class="form-group">
                                    <label for="title" class="col-sm-12 control-label lft-align">Title</label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title"
                                               placeholder="Title"
                                               value="<?php  echo (!empty($editepaper->title ))? $editepaper->title : ''; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="slug" class="col-sm-12 control-label lft-align">Slug</label>

                                    <div class="col-sm-12">

                                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug"
                                               value="<?php  echo (!empty($editepaper->clean_url ))? $editepaper->clean_url : ''; ?>">
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <label for="title" class="col-sm-12 control-label lft-align">Year</label>
                                    <div class="col-lg-6">
                                        <div class="input-group col-md-12">
                                            <select class="form-control" name="epaper_month" id="epaper_month">
                                                <option value="">Select Months</option>
                                                <option value="बैशाख" <?php echo ($epaper_month=='बैशाख') ? 'selected="selected"':'';?> >बैशाख</option>
                                                <option value="जेठ" <?php echo ($epaper_month=='जेठ')?'selected="selected"':''?>>जेठ</option>
                                                <option value="असार" <?php echo ($epaper_month=='असार')?'selected="selected"':''?>>असार</option>
                                                <option value="श्रावण" <?php echo ($epaper_month=='श्रावण')?'selected="selected"':''?>>श्रावण</option>
                                                <option value="भदौ" <?php echo ($epaper_month=='भदौ')?'selected="selected"':''?>>भदौ</option>
                                                <option value="आश्विन" <?php echo ($epaper_month=='आश्विन')?'selected="selected"':''?>>आश्विन</option>
                                                <option value="कार्तिक" <?php echo ($epaper_month=='कार्तिक')?'selected="selected"':''?>>कार्तिक</option>
                                                <option value="मंसिर" <?php echo ($epaper_month=='मंसिर')?'selected="selected"':''?>>मंसिर</option>
                                                <option value="पुष" <?php echo ($epaper_month=='पुष')?'selected="selected"':''?>>पुष</option>
                                                <option value="माघ" <?php echo ($epaper_month=='माघ')?'selected="selected"':''?>>माघ</option>
                                                <option value="फाल्गुन" <?php echo ($epaper_month=='फाल्गुन')?'selected="selected"':''?>>फाल्गुन</option>
                                                <option value="चैत्र" <?php echo ($epaper_month=='चैत्र')?'selected="selected"':''?>>चैत्र</option>
                                            </select>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <div class="input-group col-md-12">

                                                <select class="form-control" name="epaper_year" id="epape_year">
                                                    <option value="२०७५ ">२०७५ </option>
                                                </select>

                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                </div>
                                <!-- /.row -->


                                <div class="row form-group">
                                    <label for="title" class="col-sm-12 control-label lft-align">Cover Photo</label>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                         <span class="input-group-btn">
                                           <a data-input="cthumbnail" data-preview="cholder"
                                              class="btn btn-primary uploadImage">
                                               <i class="fa fa-picture-o"></i> Choose
                                           </a>
                                         </span>
                                            <input id="cthumbnail" class="form-control" type="text" name="filepath"
                                                   value="<?php  echo (!empty($editepaper->image ))? $editepaper->image : ''; ?>">
                                        </div>
                                        <div>

                                            <img id="cholder" style="margin-top:15px;max-height:100px;"
                                            <?php  echo (!empty($editepaper->image ))? 'src="'.$editepaper->image.'"' : ''; ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="title" class="col-sm-12 control-label lft-align">Pdf</label>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                         <span class="input-group-btn">
                                           <a data-input="cthumbnailpdf" data-preview="cholderpdf"
                                              class="btn btn-primary uploadImagepdf">
                                               <i class="fa fa-picture-o"></i> Choose
                                           </a>
                                         </span>
                                            <input id="cthumbnailpdf" class="form-control" type="text" name="filepath2"
                                                   value="<?php  echo (!empty($epaper_pdf ))? $epaper_pdf : ''; ?>">
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="box-footer">
                                @if(!empty($editepaper))
                                <button type="submit" class="btn btn-default">Edit</button>
                                @else
                                <button type="submit" class="btn btn-default">Save</button>
                                @endif
                            </div>


                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>
    @include('admin.partials.footer')
@endsection

@section('footer-script')
    @include('admin.partials.footer-script')
@endsection