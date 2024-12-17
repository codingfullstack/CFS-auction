<?php
function register_blocks()
{
  $blocks = [
    [ 'name' => 'bids', 'options' => [
      'render_callback' => 'bids_auction_render_cb'
    ]],
    [ 'name' => 'auction-countdown', 'options' => [
      'render_callback' => 'auction_countdown_render_cb'
    ]],
    [ 'name' => 'bid-input', 'options' => [
      'render_callback' => 'bid_input_render_cb'
    ]],
    [ 'name' => 'single-auction', 'options' => [
      'render_callback' => 'single_auction_render_cb'
    ]]
  ];

  foreach ($blocks as $block) {
    register_block_type(
      PLUGIN_DIR . 'build/blocks/' . $block['name'],
      isset($block['options']) ? $block['options'] : []
    );
  }
}