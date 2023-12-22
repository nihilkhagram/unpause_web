@include('header')
@include('sidebarnew')

<?php $baseurl = URL::to('/'); if($errors->any()){ //print_r($errors);exit;
}?>
<!-- BEGIN: Content -->
            <div class="content">
                <div class="intro-y flex items-center">
                        <h2 class="intro-y text-lg font-medium mt-10">
                        Category View
                    </h2>
                </div>

                <div class="grid grid-cols-12 gap-6 mt-5">                    
                
                    
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <div class="intro-y  ">
                            {{-- service Submaster name --}}
                            <h4 class="font-bold text-lg  ">
                                {{$category->category_name}}
                            </h4>
                            
                            <div class="p-3 my-1">
                                @if (isset($category->category_image) && $category->category_image !="")
                                <img src="{{asset($category->category_image)}}" alt="icon" class="float-right h-20">
                                @endif
                                <h5 class="font-bold  text-center">
                                Category List
                                </h5>

                            </div>              
                        </div>
                        {{-- banner sub-list --}}
                        @if($category_list->count() > 0)
                           <!-- <table class="table table-report  order-column" id="sample_3">
                                <thead>
                                    <tr>
                                        <th class="text-center whitespace-nowrap ">Sr.No.</th>
                                        <th class="text-center whitespace-nowrap">Name</th>
										 <th class="text-center whitespace-nowrap">Name</th>
                                        <th class="text-center whitespace-nowrap">Image</th>                                                             
                                        <th class="text-center whitespace-nowrap">STATUS</th>                                     
                                        
                                    </tr>
                                </thead>
                                
                                    <tbody>
                                        @foreach ($banner_list as $banner_list)
                                            <tr class="shadow">
                                                <td class="text-center whitespace-nowrap">
                                                    <div class="">{{$loop->iteration}}</div>
                                                </td>

                                                <td class="text-center whitespace-nowrap">
                                                    <div class="">{{$banner_list->title}}</div>
                                                </td>
												
												<td class="text-center whitespace-nowrap">
                                                    <div class="">{{$banner_list->subtitle}}</div>
                                                </td>

                                                <td class="text-center  whitespace-nowrap">
                                                    @if (isset($banner_list->image) && $banner_list->image !="")
                                                        <img src="{{asset($banner_list->image)}}" alt="icon" class="mr-auto ml-auto block img-thumbnail" style='height:80px;width:150px;' >
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                               
                                                <td class="text-center whitespace-nowrap ">
                                                    @if ($banner_list->is_active == 1)
                                                        <span class="text-green" style="color: green">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class=" " style="color: red">
                                                            In-Active
                                                        </span>
                                                    @endif
                                                </td>


                                            </tr>
                                        @endforeach     
                                    </tbody>
                            </table>-->
                        @else
                            <div class="text-center">
                                List is Empty
                            </div>
            
                        @endif
                </div>
            <!-- END: Data List -->
        </div>
            </div>
<!-- END: Content -->
@include('footer')

