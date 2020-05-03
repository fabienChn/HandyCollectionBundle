# HandyCollectionBundle

A handy collection manager containing some nice to have helpers for dealing with arrays and arrays of entities

## Use 

Put this in a global helpers file:

    function collect($entityObject)
    {
        return new fabienChn\HandyCollectionBundle\Component\HandyCollection($entityObject);
    }

And use it this way:

    collection(array)->pluck('id')->toArray(); // making an array of ids from an array of entities 
