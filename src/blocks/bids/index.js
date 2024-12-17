import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl } from '@wordpress/components';
import './main.css';
import block from './block.json';
registerBlockType(block.name, {
    edit({ attributes, setAttributes }) {
        const { auction_id } = attributes;
        const blockProps = useBlockProps();

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
                <div {...blockProps}>
                    <p>{__('This block dynamically displays auction bids.', 'auction-block')}</p>
                    {!auction_id && <p>{__('Please set an Auction ID.', 'auction-block')}</p>}
                </div>
            </>
        );
    },
    save() {
        return null; 
    },
});