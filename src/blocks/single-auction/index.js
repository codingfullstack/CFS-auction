import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { TextControl, PanelBody } from "@wordpress/components";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import block from "./block.json";
import "./main.css";

registerBlockType(block.name, {
  edit({ attributes, setAttributes }) {
    const { auction_id } = attributes;
    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Auction Settings", "CFS-auction")}>
            <TextControl
              label={__("Auction ID", "auction-plugin")}
              value={auction_id}
              onChange={(newVal) => setAttributes({ auction_id: newVal })}
              placeholder={__("Enter Auction ID", "auction-plugin")}
            />
          </PanelBody>
        </InspectorControls>
        <div {...useBlockProps()}>
          <h3 className="labas">{__("Auction Details", "auction-plugin")}</h3>
          <p>
            <strong>{__("Auction Title:", "auction-plugin")}</strong>{" "}
            Pavadinimas
          </p>
          <p>
            <strong>{__("Start Price:", "auction-plugin")}</strong>0 EUR
          </p>
          <p>
            <strong>{__("Buy Now Price:", "auction-plugin")}</strong>0 EUR
          </p>
          <p>
            <strong>{__("Bid Step:", "auction-plugin")}</strong>0 EUR
          </p>
          <p>
            <strong>{__("Reserve Price:", "auction-plugin")}</strong>0 EUR
          </p>
          <p>
            <strong>{__("Auction Start Date:", "auction-plugin")}</strong>{" "}
            2024-01-01
          </p>
          <p>
            <strong>{__("Auction End Date:", "auction-plugin")}</strong>{" "}
            2024-01-01
          </p>
          <p>
            <strong>{__("Auction Status:", "auction-plugin")}</strong> Open
          </p>
        </div>
      </>
    );
  },
  save() {
    return null;
  },
});
