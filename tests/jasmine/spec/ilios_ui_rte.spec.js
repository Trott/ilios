describe("ilios_ui_rte", function () {
  describe("RichTextEditor() constructor", function () {
    it("should return a RichTextEditor object", function () {
      var el = document.createElement('div');
      var editor = new ilios.ui.RichTextEditor(el);
      expect(editor instanceof ilios.ui.RichTextEditor).toBe(true);
    });

    it("should extend object with supplied attrs", function () {
      spyOn(YAHOO.lang, "augmentObject");
      var el = document.createElement('div');
      var attrs = { foober: "barbarbar" };
      var editor = new ilios.ui.RichTextEditor(el);
      expect(YAHOO.lang.augmentObject).toHaveBeenCalled();
    });
  });
});