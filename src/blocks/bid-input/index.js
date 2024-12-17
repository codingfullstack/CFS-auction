import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { TextControl, PanelBody } from "@wordpress/components";
import "./main.css";
import block from "./block.json";

registerBlockType(block.name, {
  edit({ attributes, setAttributes }) {
    const { bid_amount, auction_id } = attributes;

    // Funkcija, kuri atnaujina siūlymo sumą
    const onChangeBidAmount = (newBidAmount) => {
      setAttributes({ bid_amount: newBidAmount });
    };

    // Funkcija, kuri atnaujina aukciono ID
    const onChangeAuctionId = (newAuctionId) => {
      setAttributes({ auction_id: newAuctionId });
    };

    return (
      <div {...useBlockProps()}>
        <InspectorControls>
          <PanelBody title={__("Auction Settings", "auction-plugin")}>
            <TextControl
              label={__("Auction ID", "CFS-auction")}
              value={auction_id}
              onChange={onChangeAuctionId}
              placeholder={__("Enter the auction ID...", "CFS-auction")}
            />
          </PanelBody>
        </InspectorControls>

        <div className="auction-bid-input">
          <h3>{__("Enter Your Bid", "CFS-auction")}</h3>
          <TextControl
            label={__("Bid Amount", "CFS-auction")}
            value={bid_amount}
            onChange={onChangeBidAmount}
            placeholder={__("Enter your bid...", "CFS-auction")}
            __nextHasNoMarginBottom={true}
          />
        </div>
        <button id="submit_bid" className="submit-bid-btn">
          {__("Siūlyti", "CFS-auction")}
        </button>
      </div>
    );
  },

  // Bloko išsaugojimo funkcija (dynamic block, todėl nieko negrąžina)
  save() {
    return null; // HTML generuojama PHP, nes tai dinaminis blokas
  },
});
