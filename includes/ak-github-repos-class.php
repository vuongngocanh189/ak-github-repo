<?php
class AK_Github_Repos extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'ak_github_repo',
			'description' => 'List your personal github repo',
		);
		parent::__construct( 'ak_github_repo', 'Github Repos', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		// fetch data from Github
		$title = apply_filters('widget_title', $instance['title']);
		$github_account = esc_attr($instance['github_account']);
		$number_of_repos = esc_attr($instance['number_of_repos']);
		$response = wp_remote_get( 'https://api.github.com/users/'. $github_account .'/repos?sort=updated_at&per_page='. $number_of_repos);
		
		if ( is_array( $response ) ) {
		  	$contents = json_decode($response['body']);

		  	echo $args['before_widget'];  
		?> 
			<?php echo $args['before_title'] . $instance['title'] . $args['after_title']; ?>
			<ul class="ak-github-repos-list">
		<?php 
			foreach ($contents as $content) {
				$repo_name = ucwords(str_replace('-', " ", $content->name));
		  		?> 
		  			<li class="ak-github-repos-item">
		  				<div class="ak-repo-item-name"><a class="ak-repo-item-link" href="<?php echo $content->html_url; ?>" target="_blank"><?php echo $repo_name; ?></a></div>
		  				<div class="ak-repo-item-description"><?php echo $content->description; ?></div>
		  			</li>
		  		<?php
		  	}
		echo '</ul>' . $args['after_widget'];
		}
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		if(isset($instance['title'])) {
			$title = esc_attr($instance['title']);
		} else{
			$title = __('My Latest Github Repo');
		}

		if(isset($instance['github_account'])) {
			$github_account = esc_attr($instance['github_account']);
		} else{
			$github_account = '';
		}				

		if(isset($instance['number_of_repos'])) {
			$number_of_repos = esc_attr($instance['number_of_repos']);
		} else{
			$number_of_repos = 5;
		}

		?>
		<p>
		    <label for="<?php echo $this->get_field_id('title'); ?>">Title</label><br>
		    <input type="text" class="form-control" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
		</p>		
		<p>
		    <label for="<?php echo $this->get_field_id('github_account'); ?>">Github Username</label><br>
		    <input type="text" class="form-control" id="<?php echo $this->get_field_id('github_account'); ?>" name="<?php echo $this->get_field_name('github_account'); ?>" value="<?php echo esc_attr($github_account); ?>">
		</p>			
		</p>
		    <label for="<?php echo $this->get_field_id('number_of_repos'); ?>">Number of repos</label><br>
		    <input type="number" class="form-control" id="<?php echo $this->get_field_id('number_of_repos'); ?>" name="<?php echo $this->get_field_name('number_of_repos'); ?>" value="<?php echo esc_attr($number_of_repos); ?>">
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array (
			'title' => (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : __('My Latest Github Repo'),
			'github_account' => strip_tags($new_instance['github_account']),
			'number_of_repos' => strip_tags($new_instance['number_of_repos']) 
		);
		return $instance;
	}
}