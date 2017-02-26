class opinion:
    # CONSTRUCTOR
    def __init__(self,date,owner,comment):
        self.date = date
        self.owner = owner
        self.comment = comment

    # Getter of date
    def getDate(self):
        return self.date

    # Getter of owner
    def getOwner(self):
        return self.owner

    # Getter of comment
    def getComment(self):
        return self.comment