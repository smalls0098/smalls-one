<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/31 - 22:41
 **/

require('../../../wp-blog-header.php');
header("Content-type: text/xml");
header('HTTP/1.1 200 OK');
$posts_to_show = 1000;
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/">'
?>
  <url>
      <loc><?php echo get_home_url(); ?></loc>
      <lastmod><?php $ltime = get_lastpostmodified('GMT');$ltime = gmdate('Y-m-dTH:i:s+00:00', strtotime($ltime)); echo $ltime; ?></lastmod>
      <changefreq>daily</changefreq>
      <priority>1.0</priority>
  </url>
<?php
/* 文章页面 */
$myposts = get_posts( "numberposts=" . $posts_to_show );
foreach( $myposts as $post ) { ?>
  <url>
      <loc><?php the_permalink(); ?></loc>
      <lastmod><?php the_time('c') ?></lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.6</priority>
  </url>
<?php } /* 文章循环结束 */ ?>
<?php
/* 单页面 */
$mypages = get_pages();
if(count($mypages) > 0) {
    foreach($mypages as $page) { ?>
    <url>
      <loc><?php echo get_page_link($page->ID); ?></loc>
      <lastmod><?php echo str_replace(" ","T",get_page($page->ID)->post_modified); ?>+00:00</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.6</priority>
  </url>
<?php }} /* 单页面循环结束 */ ?>
<?php
/* 博客分类 */
$terms = get_terms('category', 'orderby=name&hide_empty=0' );
$count = count($terms);
if($count > 0){
foreach ($terms as $term) { ?>
    <url>
      <loc><?php echo get_term_link($term, $term->slug); ?></loc>
      <changefreq>weekly</changefreq>
      <priority>0.8</priority>
  </url>
<?php }} /* 分类循环结束 */?>
<?php
 /* 标签(可选) */
$tags = get_terms("post_tag");
foreach ( $tags as $key => $tag ) {
    $link = get_term_link( intval($tag->term_id), "post_tag" );
         if ( is_wp_error( $link ) )
          return false;
          $tags[ $key ]->link = $link;
?>
 <url>
      <loc><?php echo $link ?></loc>
      <changefreq>monthly</changefreq>
      <priority>0.4</priority>
  </url>
<?php  } /* 标签循环结束 */ ?>
</urlset>