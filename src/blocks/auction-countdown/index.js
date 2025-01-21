import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import './main.css';
import block from './block.json';

registerBlockType(block.name, {
    attributes: {
        auction_id: {
            type: 'string',
        },
        marginTop: {
            type: 'string',
            default: '20px', // default value for margin-top
        },
        marginBottom: {
            type: 'string',
            default: '20px', // default value for margin-bottom
        },
        padding: {
            type: 'string',
            default: '10px', // default value for padding
        },
    },

    edit({ attributes, setAttributes }) {
        const { auction_id, marginTop, marginBottom, padding } = attributes;
        const [auctionData, setAuctionData] = useState(null);
        const [remainingTime, setRemainingTime] = useState('');
        const [error, setError] = useState('');
        const blockProps = useBlockProps({
            className: "auction-countdown-container",
            style: {
                marginTop: marginTop,
                marginBottom: marginBottom,
                padding: padding,
            }
        });

        // Gauti aukciono duomenis iš REST API
        useEffect(() => {
            if (auction_id) {
                fetch(`/wp-json/auction/v1/auction-data/${auction_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            setError(data.error);
                        } else {
                            setAuctionData(data);
                        }
                    })
                    .catch(error => {
                        setError(__('Error fetching auction data', 'auction-plugin'));
                    });
            }
        }, [auction_id]);

        // Apskaičiuoti likusį laiką iki aukciono pabaigos
        useEffect(() => {
            if (auctionData && auctionData.end_date) {
                const endDate = new Date(auctionData.end_date);
                const timer = setInterval(() => {
                    const now = new Date();
                    const timeLeft = endDate - now;

                    if (timeLeft <= 0) {
                        setRemainingTime(__('Auction has ended', 'auction-plugin'));
                        clearInterval(timer);
                    } else {
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        setRemainingTime(`${hours}h ${minutes}m ${seconds}s`);
                    }
                }, 1000);

                return () => clearInterval(timer);
            }
        }, [auctionData]);

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Auction Settings', 'auction-plugin')}>
                        <TextControl
                            label={__('Auction ID', 'auction-plugin')}
                            value={auction_id}
                            onChange={(newVal) => setAttributes({ auction_id: newVal })}
                            placeholder={__('Enter Auction ID', 'auction-plugin')}
                        />
                        <TextControl
                            label={__('Margin Top', 'auction-plugin')}
                            value={marginTop}
                            onChange={(newVal) => setAttributes({ marginTop: newVal })}
                            placeholder={__('Enter Margin Top (e.g., 20px)', 'auction-plugin')}
                        />
                        <TextControl
                            label={__('Margin Bottom', 'auction-plugin')}
                            value={marginBottom}
                            onChange={(newVal) => setAttributes({ marginBottom: newVal })}
                            placeholder={__('Enter Margin Bottom (e.g., 20px)', 'auction-plugin')}
                        />
                        <TextControl
                            label={__('Padding', 'auction-plugin')}
                            value={padding}
                            onChange={(newVal) => setAttributes({ padding: newVal })}
                            placeholder={__('Enter Padding (e.g., 10px)', 'auction-plugin')}
                        />
                    </PanelBody>
                </InspectorControls>
                <div {...blockProps}>
                    <h3>{__('Auction Countdown', 'auction-plugin')}</h3>
                    {error && <p>{error}</p>}
                    {auctionData && (
                        <p className='auction-countdown-time'>{__('Time remaining:', 'auction-plugin')} {remainingTime}</p>
                    )}
                    {!auction_id && <p>{__('Please set an Auction ID.', 'auction-plugin')}</p>}
                </div>
            </>
        );
    },

    save() {
        return null; // Dynamic block: HTML generated by PHP.
    },
});
