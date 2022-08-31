<div class="col-md-3 search">
            <div class="form">
                <form action="<?php echo BASEURL;?>blog/search" method="post">
                    <div class="form-group">
                        <label class="control-label">Blog Search</label>

                        <div class="input-group">
                                <input type="text" name="keyword" autocomplete="off" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Go!</button>
                                </span>
                        </div>
                    </div>
                </form>
            </div>

            <label class="control-label">Find Post By Search Keywords</label>
            <ul class="list">
            <?php 
                if(!empty($data)):
                    foreach($data as $row):?>
                        <li><a href="<?php echo BASEURL;?>blog/post/<?php echo $row->blog_id;?>"><?php echo $row->title; ?></a></li>
                    <?php 
                        endforeach;
                        else:
                    ?>
                <li class="text-center">No Record Avaiable </li>
            <?php        
                endif;
            ?> 
            </ul>
        </div>