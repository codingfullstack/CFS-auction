import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { TextControl, PanelBody } from "@wordpress/components";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import block from "./block.json";
import "./main.css";

registerBlockType(block.name, {
  edit({ attributes, setAttributes }) {
    const { auction_id } = attributes;
    const blockProps = useBlockProps({
      className: "auction-bids-list-container",
    });

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
        <div {...blockProps}>
          <h3>{__("Auction Bids", "CFS-auction")}</h3>
          <ul id="bid_list">
            <li>{__("25 EUR", "CFS-auction")}</li>
            <li>{__("35 EUR", "CFS-auction")}</li>
            <li>{__("69 EUR", "CFS-auction")}</li>
          </ul>
        </div>
      </>
    );
  },
  save() {
    return null; // Dynamic rendering via PHP
  },
});
