<?php 
// prevent direct access
if (!isset($theme)) {
die('You Can not Access Directly');	
}
?>
<div class="page-header page-heading">
            <h1><i class="fa fa-paint-brush"></i> Theme Setting</h1>
        </div>
		<?php if (isset($message)) {echo $message;} ?>
		<form role="form" method="POST" action="">
		  <div class="form-group">
			<label for="home_category_news_number">Number Of News In Each Category Block at HomePage</label>
			<select name="home_category_news_number" id="home_category_news_number" class="form-control">
			<?php for ($n=1;$n<11;$n++) { ?>
			<option value="<?php echo $n; ?>" <?php if ($theme['home_category_news_number'] == $n) {echo 'SELECTED';} ?>><?php echo $n; ?></option>
			<?php } ?>
			</select>
		  </div>
		  <div class="form-group">
			<label for="category_news_number">Number Of News In Each Category Page</label>
			<input type="number" name="category_news_number" id="category_news_number" class="form-control" value="<?php echo $theme['category_news_number']; ?>" placeholder="12" />
		  </div>
		  <div class="form-group">
			<label for="source_news_number">Number Of News In Each Source Page</label>
			<input type="number" name="source_news_number" id="source_news_number" class="form-control" value="<?php echo $theme['source_news_number']; ?>" placeholder="12" />
		  </div>
		  <div class="form-group">
			<label for="search_news_number">Number Of News In Each Search results Page</label>
			<input type="number" name="search_news_number" id="search_news_number" class="form-control" value="<?php echo $theme['search_news_number']; ?>" placeholder="12" />
		  </div>
		  <div class="form-group">
			<label for="related_news_number">Number Of Related News In Single Article Page</label>
			<select name="related_news_number" id="related_news_number" class="form-control">
			<?php for ($r=1;$r<11;$r++) { ?>
			<option value="<?php echo $r; ?>" <?php if ($theme['related_news_number'] == $r) {echo 'SELECTED';} ?>><?php echo $r; ?></option>
			<?php } ?>
			</select>
		  </div>
		  <div class="form-group">
			<label for="top_news_number">Number Of News In Top News Widget</label>
			<select name="top_news_number" id="top_news_number" class="form-control">
			<?php for ($t=1;$t<11;$t++) { ?>
			<option value="<?php echo $t; ?>" <?php if ($theme['top_news_number'] == $t) {echo 'SELECTED';} ?>><?php echo $t; ?></option>
			<?php } ?>
			</select>
		  </div>
		  <div class="form-group">
			<input type="checkbox" name="allow_lazyload" id="allow_lazyload" value="1" <?php if (isset($theme['allow_lazyload']) AND $theme['allow_lazyload'] == 1) {echo 'CHECKED';} ?> /> <span class="checkbox-label">Allow Image Loading using LazyLoad ?</span>
		  </div>
		  <button type="submit" name="save" class="btn btn-primary">Save</button>
		</form>