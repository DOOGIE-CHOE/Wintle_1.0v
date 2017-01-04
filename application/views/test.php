
<code>
    [insert_php]

    echo '<section id="hs-featured-post-section class="hs-section">';
    echo '  <div class="hs-container">';

        $hashone_featured_title = get_theme_mod('hashone_featured_title', __( 'Our Features', 'hashone'));
        $hashone_featured_desc = get_theme_mod('hashone_featured_desc', __( 'Check out cool featured of the theme', 'hashone'));




        if($hashone_featured_title){


        echo ' <h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s">' ;echo esc_html($hashone_featured_title); echo'</h2>';
        }

        if($hashone_featured_desc){
        echo ' <div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">' ;echo esc_html($hashone_featured_desc); echo '</div>';
        }

        echo ' <div class="hs-featured-post-wrap hs-clearfix">';

            $icon = [' fa fa-music',' fa fa-group',' fa fa-share-square-o'];
            for( $i = 1; $i < 4; $i++ ){

            $hashone_featured_page_id = get_theme_mod('hashone_featured_page'.$i, $hashone_page);
            $hashone_featured_page_icon = get_theme_mod('hashone_featured_page_icon'.$i, 'fa-bell');

            if($hashone_featured_page_id){
            $args = array( 'page_id' => $hashone_featured_page_id );
            $query = new WP_Query($args);
            if($query->have_posts()):
            while($query->have_posts()) : $query->the_post();
            $hashone_wow_delay = ($i/2)-1+0.5;

            echo ' <div class="hs-featured-post hs-featured-post'; echo $i;  echo 'wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay=" echo $hashone_wow_delay; s">';
                echo '  <div class="hs-featured-icon"><i class="fa';  echo  $icon[$i-1] ;echo' "></i></div>';
                echo '  <h3>';
                    echo '     <a href=" the_permalink(); ">'; the_title(); echo '</a>';
                    echo ' </h3>';
                echo '  <div class="hs-featured-excerpt">';

                    if(has_excerpt()){
                    echo get_the_excerpt();
                    }else{
                    echo hashone_excerpt( get_the_content(), 100);
                    }
                    echo '   </div>';
                echo ' </div>';

            endwhile;
            endif;
            wp_reset_postdata();
            }
            }

            echo '  </div>';
        echo ' </div>';
    echo ' </section>';
    [/insert_php]

[insert_php]
    if( get_theme_mod('hashone_disable_service_sec') != 'on' ){
    echo '<section id="hs-service-post-section" class="hs-section">';
        echo ' <div class="hs-service-left-bg"></div>';
        echo ' <div class="hs-container">';
            echo '   <div class="hs-service-posts">';

                $hashone_service_title = get_theme_mod('hashone_service_title',__('Why Choose Us', 'hashone'));
                $hashone_service_sub_title = get_theme_mod('hashone_service_sub_title', __('Let us do all things for you', 'hashone'));


 if($hashone_service_title){
                echo '   <h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s">'; echo esc_html($hashone_service_title); echo '</h2>';
                 }

 if($hashone_service_sub_title){
                echo ' <div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">'; echo esc_html($hashone_service_sub_title); echo '</div>';
                 }

                echo ' <div class="hs-service-post-wrap">';


                    $icon = [' fa fa-music',' fa fa-group',' fa fa-star',' fa fa-smile-o',' fa fa-dollar'];

                    for( $i = 1; $i < 7; $i++ ){
                    $hashone_service_page_id = get_theme_mod('hashone_service_page'.$i, $hashone_page);
                    $hashone_service_page_icon = get_theme_mod('hashone_service_page_icon'.$i, 'fa-globe');

                    if($hashone_service_page_id){
                    $args = array( 'page_id' => $hashone_service_page_id );
                    $query = new WP_Query($args);
                    if($query->have_posts()):
                    while($query->have_posts()) : $query->the_post();
                    $hashone_wow_delay = ($i*300)+300;

                    echo ' <div class="hs-clearfix hs-service-post hs-service-post echo $i;  wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="'; echo $hashone_wow_delay; echo 'ms">';
                        echo '     <div class="hs-service-icon">';
                            echo '        <i class="fa'; echo $icon[$i-1];  echo'"></i>';
                            echo '    </div>';

                        echo '   <div class="hs-service-excerpt">';
                            echo '       <h6><a href=" the_permalink(); ">'; the_title(); echo'</a></h6>';
                            
                            if(has_excerpt()){
                            echo get_the_excerpt();
                            }else{
                            echo hashone_excerpt( get_the_content(), 100);
                            }

                            echo '     </div>';
                        echo '   </div>';
                    
                    endwhile;
                    endif;
                    wp_reset_postdata();
                    }
                    }

                    echo '     </div>';
                echo '   </div>';
            echo '   </div>';
        echo ' </section>';
     } [/insert_php]



</code>
</code>


[insert_php]
    echo '<section id="hs-team-section" class="hs-section">';
    echo '<div class="hs-container">';
            
            $hashone_team_title = get_theme_mod('hashone_team_title', __('Meet Our Team', 'hashone'));
            $hashone_team_sub_title = get_theme_mod('hashone_team_sub_title', __( 'Experts who works for us','hashone' ));
            

             if($hashone_team_title){
        echo '    <h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s">'; echo esc_html($hashone_team_title); echo '</h2>';
             } 

             if($hashone_team_sub_title){
        echo '    <div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">'; echo esc_html($hashone_team_sub_title); echo '</div>';
             }

        echo ' <div class="hs-team-member-wrap hs-clearfix">';
                
                for( $i = 1; $i < 5; $i++ ){
                    $hashone_team_page_id = get_theme_mod('hashone_team_page'.$i, $hashone_page);

                    if($hashone_team_page_id){
                        $args = array( 'page_id' => $hashone_team_page_id );
                        $query = new WP_Query($args);
                        if($query->have_posts()):
                            while($query->have_posts()) : $query->the_post();
                                $hashone_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'hashone-team-thumb');
                                $hashone_team_designation = get_theme_mod('hashone_team_designation'.$i, __('CEO', 'hashone'));
                                $hashone_team_facebook = get_theme_mod('hashone_team_facebook'.$i, '#');
                                $hashone_team_twitter = get_theme_mod('hashone_team_twitter'.$i, '#');
                                $hashone_team_google_plus = get_theme_mod('hashone_team_google_plus'.$i, '#');
                                $hashone_team_linkedin = get_theme_mod('hashone_team_linkedin'.$i, '#');
                                $hashone_wow_delay = ($i/2)-1+0.5;

            echo ' <div class="hs-team-member wow pulse" data-wow-duration="0.5s" data-wow-delay=" echo $hashone_wow_delay; s">';
                                     if( has_post_thumbnail() ){
                echo '   <div class="hs-team-member-image">';
                    echo '     <img src="'; echo esc_url($hashone_image[0]); echo '" alt=" esc_attr(get_the_title()); " />';

                    echo '  <a href="'; echo  the_permalink(); echo '" class="hs-team-member-excerpt">';
                        echo '   <div class="hs-team-member-excerpt-wrap">';
                            echo '	<span>';
									
                                    if(has_excerpt()){
                                        echo get_the_excerpt();
                                    }else{
                                        echo hashone_excerpt( get_the_content() , 100 );
                                    }
                                    
								echo '	</span>';
                            echo '  </div>';
                        echo '  </a>';

                                             if( $hashone_team_facebook || $hashone_team_twitter || $hashone_team_google_plus ){
                    echo ' <div class="hs-team-social-id">';
                                                     if($hashone_team_facebook){
                        echo '  <a target="_blank" href="'; echo esc_url($hashone_team_facebook); echo '"><i class="fa fa-facebook"></i></a>';
                                                     } 

                                                     if($hashone_team_twitter){
                        echo '  <a target="_blank" href="'; echo esc_url($hashone_team_twitter); echo '"><i class="fa fa-twitter"></i></a>';
                                                     } 

                                                     if($hashone_team_google_plus){
                        echo ' <a target="_blank" href="'; echo esc_url($hashone_team_google_plus);echo ' "><i class="fa fa-google-plus"></i></a>';
                                                     } 

                                                     if($hashone_team_linkedin){
                        echo ' <a target="_blank" href="'; echo esc_url($hashone_team_linkedin); echo '"><i class="fa fa-linkedin"></i></a>';
                                                     }
                        echo ' </div>';
                                             }
                    echo ' </div>';
                                     }

                echo ' <h6><a href="'; the_permalink(); echo '">'; the_title(); echo '</a></h6>';

                                     if($hashone_team_designation){
                echo '  <div class="hs-team-designation">'; echo esc_html($hashone_team_designation); echo '</div>';
                                     }


                echo '  </div>';
                                
                            endwhile;
                        endif;
                        wp_reset_postdata();
                    }
                }

            echo '</div>';
        echo ' </div>';
    echo ' </section>';

[/insert_php]