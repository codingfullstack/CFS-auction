import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { TextControl, PanelBody } from '@wordpress/components';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import './main.css';
import block from './block.json';

registerBlockType(block.name, {
    edit({ attributes, setAttributes }) {
        const { auction_id, auction_title, start_price, buy_now_price, bid_step, reserve_price, auction_date_start, auction_date_end, status } = attributes;

        return (
            <>
                <InspectorControls>
                <PanelBody title={__('Auction Settings', 'auction-block')}>
                        <TextControl
                            label={__('Auction ID', 'auction-block')}
                            value={auction_id}
                            onChange={(newVal) => setAttributes({ auction_id: newVal })}
                            placeholder={__('Enter Auction ID', 'auction-block')}
                        />
                    </PanelBody>
                </InspectorControls>
                <div {...useBlockProps()}>
                    <h3>{__('Auction Details', 'auction-plugin')}</h3>
                    <p><strong>{__('Auction Title:', 'auction-plugin')}</strong> {auction_title}</p>
                    <p><strong>{__('Start Price:', 'auction-plugin')}</strong> {start_price} EUR</p>
                    <p><strong>{__('Buy Now Price:', 'auction-plugin')}</strong> {buy_now_price} EUR</p>
                    <p><strong>{__('Bid Step:', 'auction-plugin')}</strong> {bid_step} EUR</p>
                    <p><strong>{__('Reserve Price:', 'auction-plugin')}</strong> {reserve_price} EUR</p>
                    <p><strong>{__('Auction Start Date:', 'auction-plugin')}</strong> {auction_date_start}</p>
                    <p><strong>{__('Auction End Date:', 'auction-plugin')}</strong> {auction_date_end}</p>
                    <p><strong>{__('Auction Status:', 'auction-plugin')}</strong> {status}</p>
                </div>
            </>
        );
    },
    save() {
        return null; // HTML generuojama PHP, nes tai dinaminis blokas
      },
});