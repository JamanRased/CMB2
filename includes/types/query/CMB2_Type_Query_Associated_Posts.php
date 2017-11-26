<?php
/**
 * CMB2 Query Associated Posts
 *
 * @since  2.2.7
 *
 * @category  WordPress_Plugin
 * @package   CMB2
 * @author    CMB2 team
 * @license   GPL-2.0+
 * @link      https://cmb2.io
 */

/**
 * Class CMB2_Type_Query_Associated_Posts
 */
class CMB2_Type_Query_Associated_Posts extends CMB2_Type_Query_Associated_Objects {

	/**
	 * @return string
	 */
	public function query_type() {
		return 'post';
	}

	/**
	 * @return array
	 */
	public function default_query_args() {
		return array(
			'post_type'           => 'post',
			'posts_per_page'      => 100,
			'orderby'             => 'name',
			'order'               => 'ASC',
			'ignore_sticky_posts' => true,
			'post__not_in'        => array(),
		);
	}

	/**
	 * @param WP_Post $object
	 *
	 * @return string
	 */
	public function get_title( $object ) {
		return get_the_title( $object->ID );
	}

	/**
	 * @param WP_Post $object
	 *
	 * @return string
	 */
	public function get_thumb( $object ) {
		return get_the_post_thumbnail( $object->ID, array( 50, 50 ) );
	}

	/**
	 * @param WP_Post $object
	 *
	 * @return string
	 */
	public function get_edit_link( $object ) {
		return get_edit_post_link( $object );
	}

	/**
	 * @param $id
	 *
	 * @return null|WP_Post
	 */
	public function get_object( $id ) {
		return get_post( $id );
	}

	/**
	 * @param WP_Post $object
	 *
	 * @return int
	 */
	public function get_id( $object ) {
		return $object->ID;
	}

	/**
	 * @param $ids
	 *
	 * @return void
	 */
	public function set_include( $ids ) {
		$this->query_args['post__in'] = (array) $ids;
	}

	/**
	 * @param $count
	 *
	 * @return void
	 */
	public function set_number( $count ) {
		$this->query_args['posts_per_page'] = $count;
	}

	/**
	 * @param $ids
	 *
	 * @return void
	 */
	public function set_exclude( $ids ) {
		$this->query_args['post__not_in'] = (array) $ids;
	}

	/**
	 * @param object $object
	 *
	 * @return mixed
	 */
	public function get_object_type_label( $object ) {
		$post_type_obj = get_post_type_object( $object->post_type );
		$label = isset( $post_type_obj->labels->singular_name ) ? $post_type_obj->labels->singular_name : $post_type_obj->label;
		return $label;
	}

	/**
	 * @return array
	 */
	public function get_all_object_type_labels() {
		$labels = array();

		foreach ( (array) $this->query_args['post_type'] as $post_type ) {
			// Get post type object for attached post type
			$post_type_obj = get_post_type_object( $post_type );

			// continue if we don't have a label for the post type
			if ( ! $post_type_obj || ! isset( $post_type_obj->labels->name ) ) {
				continue;
			}

			$labels[] = $post_type_obj->labels->name;
		}

		return $labels;
	}
}
