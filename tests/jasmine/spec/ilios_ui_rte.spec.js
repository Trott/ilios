describe("ilios_ui_rte", function () {
  describe("RichTextEditor() constructor", function () {
    it("should return a RichTextEditor object", function () {
      var el = document.createElement('div');
      var editor = new ilios.ui.RichTextEditor(el);
      expect(editor instanceof ilios.ui.RichTextEditor).toBe(true);
    });
  });
});