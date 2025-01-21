import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { TextControl, PanelBody } from "@wordpress/components";
import "./main.css";
import block from "./block.json";

registerBlockType(block.name, {
  edit({ attributes, setAttributes }) {
    const { bid_amount, auction_id } = attributes;
    const blockProps = useBlockProps({ className: "auction-details" });

    // Funkcija, kuri atnaujina siūlymo sumą
    const onChangeBidAmount = (newBidAmount) => {
      setAttributes({ bid_amount: newBidAmount });
    };

    // Funkcija, kuri atnaujina aukciono ID
    const onChangeAuctionId = (newAuctionId) => {
      setAttributes({ auction_id: newAuctionId });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Auction Settings", "CFS-auction")}>
            <TextControl
              label={__("Auction ID", "CFS-auction")}
              value={auction_id}
              onChange={onChangeAuctionId}
              placeholder={__("Enter the auction ID...", "CFS-auction")}
            />
          </PanelBody>
        </InspectorControls>

        <div
          {...useBlockProps({ className: "auction-bid-input-container" })}
        >
          <h3>{__("Enter Your Bid", "CFS-auction")}</h3>
          <input
            type="text"
            id="bid_amount"
            className="auction-bid-input"
            value={bid_amount}
            placeholder={__("Enter your bid...", "CFS-auction")}
          />
          <button
            id="submit_bid"
          >
            {__("Siūlyti", "CFS-auction")}
          </button>
        </div>
      </>
    );
  },
  save() {
    return null; // HTML generuojama PHP, nes tai dinaminis blokas
  },
});
