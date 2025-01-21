import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { TextControl, PanelBody } from "@wordpress/components";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import block from "./block.json";
import "./main.css";

registerBlockType(block.name, {
  edit({ attributes, setAttributes }) {
    const { auction_id } = attributes;
    const blockProps = useBlockProps({ className: "auction-details" });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Auction Settings", "auction-plugin")}>
            <TextControl
              label={__("Auction ID", "auction-plugin")}
              value={auction_id}
              onChange={(newVal) => setAttributes({ auction_id: newVal })}
              placeholder={__("Enter Auction ID", "auction-plugin")}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps} >
          <h2>{__("Auction Title", "auction-plugin")}</h2>
          <div className="main-image-container">
            <img id="mainAuctionImage" src="#" alt="Main Auction" className="main-auction-image" />
          </div>
          <div className="thumbnail-container" id="thumbnailContainer">
            <img src="#" alt="Thumbnail 1" className="thumbnail-image" />
            <img src="#" alt="Thumbnail 2" className="thumbnail-image" />
          </div>
          <p>
            {__("Start Price:", "auction-plugin")} <span>0 EUR</span>
          </p>
          <p>
            {__("Buy Now:", "auction-plugin")} <span>0 EUR</span>
          </p>
          <p>
            {__("Bid Step:", "auction-plugin")} <span>0 EUR</span>
          </p>
          <p>
            {__("Auction Start Date:", "auction-plugin")} <span>2024-01-01</span>
          </p>
          <p>
            {__("Auction End Date:", "auction-plugin")} <span>2024-01-01</span>
          </p>
          <p>
            {__("Status:", "auction-plugin")} <span className="auction-status">Open</span>
          </p>
        </div>
      </>
    );
  },
  save() {
    return null; // Dynamic rendering via PHP
  },
});
